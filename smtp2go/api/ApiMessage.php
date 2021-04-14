<?php
namespace SMTP2GO\Api;

use SMTP2GO\MimetypeHelper;
use SMTP2GO\WpmailCompat;

/**
 * Creates an email message payload to send through the request api
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 * @package    SMTP2GO\WordpressPlugin
 */
class ApiMessage implements Requestable
{
    /**
     * The api key
     *
     * @var string
     */
    protected $api_key;

    /**
     * Custom headers
     *
     * @var array
     */
    protected $custom_headers;

    /**
     * Sender RFC-822 formatted email "John Smith <john@example.com>"
     *
     * @var string
     */
    protected $sender;

    /**
     * the email recipients
     *
     * @var array
     */
    protected $recipients = array();

    /**
     * The CC'd recipients
     *
     * @var string|array
     */
    protected $cc;

    /**
     * The BCC'd recipients
     *
     * @var string|array
     */
    protected $bcc;

    /**
     * The email subject
     *
     * @var string
     */
    protected $subject;

    /**
     * The email message
     *
     * @var string
     */
    protected $message;

    /**
     * The plain text part of a multipart email
     *
     * @var string
     */
    protected $alt_message;

    /**
     * Custom email headers
     *
     * @var string|array
     */
    protected $headers;

    /**
     * The data parsed from the $wp_headers
     *
     * @var array
     */
    private $parsed_headers;

    /**
     * The data parsed from the $wp_attachments
     *
     * @var array
     * @deprecated 1.1.0
     */
    private $parsed_attachments;

    /**
     * Attachments not added through the $wp_attachments variable
     *
     * @var string|array
     * @deprecated 1.1.0
     */
    protected $attachments;

    protected $phpmailer_attachments = array();

    /**
     * Inline attachments, only supported through this class
     *
     * @var string|array
     */
    protected $inlines;

    /**
     * The content type of the email, can be either text/plain or text/html
     *
     * @var string
     */
    protected $content_type = '';

    /**
     * endpoint to send to
     *
     * @var string
     */
    protected $endpoint = 'email/send';

    /**
     * Create instance - arguments mirror those of the wp_mail function
     *
     * @param mixed $wp_recipients
     * @param mixed $wp_subject
     * @param mixed $wp_message
     * @param mixed $wp_headers
     * @param mixed $wp_attachments
     */
    public function __construct($wp_recipients, $wp_subject, $wp_message, $wp_headers = '', $wp_attachments = array())
    {
        $this->setRecipients($wp_recipients)->setSubject($wp_subject)->setMessage($wp_message);

        $this->processWpHeaders($wp_headers);

        $this->processWpAttachments($wp_attachments);
    }

    /**
     * Process the headers passed in from wordpress
     *
     * @param mixed $wp_headers
     * @return void
     */
    protected function processWpHeaders($wp_headers)
    {
        $compat = new WpmailCompat;

        $this->parsed_headers = $compat->processHeaders($wp_headers);
    }

    /**
     * Process the attachments passed in from wordpress
     *
     * @param mixed $wp_attachments
     * @return void
     */
    protected function processWpAttachments($wp_attachments)
    {
        $compat = new WpmailCompat;

        $this->parsed_attachments = $compat->processAttachments($wp_attachments);
    }

    /**
     * initialise the instance with values from the plugin options page
     *
     * @since 1.0.1
     * @return void
     */
    public function initFromOptions()
    {
        $this->setSender(get_option('smtp2go_from_address'), get_option('smtp2go_from_name'));
        $this->setCustomHeaders(get_option('smtp2go_custom_headers'));
    }

    /**
     * Builds the JSON to send to the SMTP2GO API
     *
     * @return void
     */
    public function buildRequestPayload()
    {
        /** the body of the request which will be sent as json */
        $body = array();

        $body['to']  = $this->buildRecipients();
        $body['cc']  = $this->buildCC();
        $body['bcc'] = $this->buildBCC();

        $body['sender'] = $this->getSender();

        //if it hasn't already been specified, check the headers
        if (empty($this->content_type) && !empty($this->parsed_headers['content-type'])) {
            $this->content_type = $this->parsed_headers['content-type'];
        }
        if ($this->content_type === 'multipart/alternative') {
            $body['html_body'] = $this->getMessage();
            $body['text_body'] = $this->getAltMessage();
        } elseif ($this->content_type === 'text/html') {
            $body['html_body'] = $this->getMessage();
        } else {
            $body['text_body'] = $this->getMessage();
        }

        $body['custom_headers'] = $this->buildCustomHeaders();
        $body['subject']        = $this->getSubject();
        $body['attachments']    = $this->buildAttachments();
        $body['inlines']        = $this->buildInlines();

        return array(
            'method' => 'POST',
            'body'   => $body,
        );
    }

    public function buildAttachments()
    {
        $helper = new MimetypeHelper;

        $attachments = array();

        foreach ((array) $this->attachments as $path) {
            $attachments[] = array(
                'filename' => basename($path),
                'fileblob' => base64_encode(file_get_contents($path)),
                'mimetype' => $helper->getMimeType($path),
            );
        }
        foreach ($this->parsed_attachments as $path) {
            $attachments[] = array(
                'filename' => basename($path),
                'fileblob' => base64_encode(file_get_contents($path)),
                'mimetype' => $helper->getMimeType($path),
            );
        }
        //Phpmailer has already determined the mime type
        foreach ($this->phpmailer_attachments as $attachment_data) {
            $attachments[] = array(
                'filename' => $attachment_data[1],
                'fileblob' => base64_encode(file_get_contents($attachment_data[0])),
                'mimetype' => $attachment_data[3],
            );
        }

        return $attachments;
    }

    public function buildInlines()
    {
        $helper = new MimetypeHelper;

        $inlines = array();

        foreach ((array) $this->inlines as $path) {
            $inlines[] = array(
                'filename' => basename($path),
                'fileblob' => base64_encode(file_get_contents($path)),
                'mimetype' => $helper->getMimeType($path),
            );
        }
        return $inlines;
    }

    /**
     * Build an array of bcc recipients by combining ones natively set
     * or passed through the $wp_headers constructor variable
     *
     * @since 1.0.1
     * @return array
     */

    public function buildCC()
    {
        $cc_recipients = array();
        foreach ((array) $this->cc as $cc_recipient) {
            if (!empty($cc_recipient)) {
                $cc_recipients[] = $this->rfc822($cc_recipient);
            }
        }
        foreach ($this->parsed_headers['cc'] as $cc_recipient) {
            if (!empty($cc_recipient)) {
                $cc_recipients[] = $this->rfc822($cc_recipient);
            }
        }
        return $cc_recipients;
    }

    /**
     * Build an array of bcc recipients by combining ones natively set
     * or passed through the $wp_headers constructor variable
     *
     * @since 1.0.1
     * @return array
     */
    public function buildBCC()
    {
        $bcc_recipients = array();
        foreach ((array) $this->bcc as $bcc_recipient) {
            if (!empty($bcc_recipient)) {
                $bcc_recipients[] = $this->rfc822($bcc_recipient);
            }
        }
        foreach ($this->parsed_headers['bcc'] as $bcc_recipient) {
            if (!empty($bcc_recipient)) {
                $bcc_recipients[] = $this->rfc822($bcc_recipient);
            }
        }
        return $bcc_recipients;
    }

    private function rfc822($email)
    {
        //if its just a plain old email wrap it up
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '<' . $email . '>';
        }
        return $email;
    }

    public function buildCustomHeaders()
    {
        $raw_custom_headers = $this->getCustomHeaders();

        $custom_headers = array();

        if (!empty($raw_custom_headers['header'])) {
            foreach ($raw_custom_headers['header'] as $index => $header) {
                if (!empty($header) && !empty($raw_custom_headers['value'][$index])) {
                    $custom_headers[] = array(
                        'header' => $header,
                        'value'  => $raw_custom_headers['value'][$index],
                    );
                }
            }
        }
        if (!empty($this->parsed_headers['headers'])) {
            foreach ((array) $this->parsed_headers['headers'] as $name => $content) {
                if (!empty($name) && !empty($content)) {
                    $custom_headers[] = array(
                        'header' => $name,
                        'value'  => $content,
                    );
                }
            }
            //not sure if this is required but is native functionality
            if (false !== stripos($this->parsed_headers['content-type'], 'multipart') && !empty($this->parsed_headers['boundary'])) {
                $custom_headers[] = array(
                    'header' => 'Content-Type: ' . $this->parsed_headers['content-type'],
                    'value'  => 'boundary="' . $this->parsed_headers['boundary'] . '"',
                );
            }
        }
        //@todo should we allow this to overwrite an existing one from the settings?
        if (!empty($this->parsed_headers['reply-to'])) {
            $value = is_array($this->parsed_headers['reply-to']) ? reset($this->parsed_headers['reply-to']) : $this->parsed_headers['reply-to'];
            if (!empty($value)) {
                $custom_headers[] = array(
                    'header' => 'Reply-To',
                    'value'  => $value,
                );
            }
        }

        return $custom_headers;
    }
    /**
     * create an array of recipients to send to the api
     * @todo check how these are formatted and parse appropriately
     * @return void
     */
    public function buildRecipients()
    {
        $recipients = array();

        if (!is_array($this->recipients)) {
            $recipients[] = $this->rfc822($this->recipients);
        } else {
            foreach ($this->recipients as $recipient_item) {
                if (!empty($recipient_item)) {
                    $recipients[] = $this->rfc822($recipient_item);
                }
            }
        }
        return $recipients;
    }

    /**
     * Get endpoint to send to
     *
     * @return  string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set endpoint to send to
     *
     * @param  string  $endpoint  endpoint to send to
     *
     * @return  self
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get custom headers - expected format is the unserialized array
     * from the stored smtp2go_custom_headers option
     *
     * @return  array
     */
    public function getCustomHeaders()
    {
        return $this->custom_headers;
    }

    /**
     * Set custom headers - expected format is the unserialized array
     * from the stored smtp2go_custom_headers option
     *
     * @param  array  $custom_headers  Custom headers
     *
     * @return  self
     */
    public function setCustomHeaders($custom_headers)
    {
        if (is_array($custom_headers)) {
            $this->custom_headers = $custom_headers;
        }

        return $this;
    }

    /**
     * Get sender
     *
     * @return  string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set sender as RFC-822 formatted email "John Smith <john@example.com>"
     *
     * @param string $email
     * @param string $name
     *
     * @return self
     */
    public function setSender($email, $name = '')
    {
        if (!empty($name)) {
            $email        = str_replace(['<', '>'], '', $email);
            $this->sender = "\"$name\" <$email>";
        } else {
            $this->sender = "$email";
        }

        return $this;
    }

    /**
     * Get the email subject
     *
     * @return  string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the email subject
     *
     * @param  string  $subject  The email subject
     *
     * @return  self
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the email message
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the email message
     *
     * @param  string  $message  The email message
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the email recipients
     *
     * @return  array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Set the email recipients
     *
     * @param  string|array  $recipients  the email recipients
     *
     * @return  self
     */
    public function setRecipients($recipients)
    {
        if (!empty($recipients)) {
            if (is_string($recipients)) {
                $this->recipients = array($recipients);
            } else {
                $this->recipients = $recipients;
            }
        }

        return $this;
    }

    public function addRecipient($email, $name = '')
    {
        if (!empty($name)) {
            $email              = str_replace(['<', '>'], '', $email);
            $this->recipients[] = "$name <$email>";
        } else {
            $this->recipients[] = "$email";
        }
    }

    /**
     * Get the BCC'd recipients
     *
     * @return  string|array
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set the BCC'd recipients
     *
     * @param  string|array  $bcc  The BCC'd recipients
     *
     * @return  self
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * Get the CC'd recipients
     *
     * @return  string|array
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set the CC'd recipients
     *
     * @param  string|array  $cc  The CC'd recipients
     *
     * @return  self
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * Get attachments not added through the $wp_attachments variable
     *
     * @return  string|array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set attachments not added through the $wp_attachments variable
     *
     * @param  string|array  $attachments Attachments not added through the $wp_attachments variable
     *
     * @return  self
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Get inline attachments
     *
     * @return  string|array
     */
    public function getInlines()
    {
        return $this->inlines;
    }

    /**
     * Set inline attachments, only supported through this class
     *
     * @param  string|array  $inlines  Inline attachments
     *
     * @return  self
     */
    public function setInlines($inlines)
    {
        $this->inlines = $inlines;

        return $this;
    }

    /**
     * Get the email content type
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * Set the email content type
     * @param string
     * @return  self
     */
    public function setContentType($content_type)
    {
        $content_type = trim(strtolower($content_type));

        if (in_array($content_type, array('text/plain', 'text/html', 'multipart/alternative'))) {
            $this->content_type = $content_type;
        }

        return $this;
    }

    /**
     * Get the plain text part of a multipart email
     *
     * @return  string
     */
    public function getAltMessage()
    {
        return $this->alt_message;
    }

    /**
     * Set the plain text part of a multipart email
     *
     * @param  string  $alt_message  The plain text part of a multipart email
     *
     * @return  self
     */
    public function setAltMessage(string $alt_message)
    {
        $this->alt_message = $alt_message;

        return $this;
    }

    /**
     * Set attachements in the array format used by phpmailer
     * @param array $attachments
     */

    public function setMailerAttachments(array $attachments)
    {
        $this->phpmailer_attachments = $attachments;
    }

    /**
     * Get the data parsed from the $wp_headers
     *
     * @return  array
     */
    public function getParsedHeaders()
    {
        return $this->parsed_headers;
    }
}
