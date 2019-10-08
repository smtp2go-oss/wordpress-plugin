<?php

/**
 * Facilitates communication with the Smtp2Go api
 */
class Smtp2GoApi
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
     * @var string|array
     */
    protected $recipients;

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
     * Custom email headers
     *
     * @var string|array
     */
    protected $headers;

    /**
     * Attachments
     *
     * @var string|array
     */
    protected $attachments;

    /**
     * endpoint to send to
     *
     * @var string
     */
    protected $endpoint = 'https://api.smtp2go.com/v3/email/send';

    public function __construct($recipients, $subject, $message, $headers = '', $attachments = array())
    {
        $this->recipients  = $recipients;
        $this->subject     = $subject;
        $this->message     = $message;
        $this->headers     = $headers;
        $this->attachments = $attachments;
    }

    /**
     * initial the instance with values from the plugin options page
     *
     * @since 1.0.0
     * @return void
     */
    public function initFromOptions()
    {
        $this->setApiKey(get_option('smtp2go_api_key'));
        $this->setSender(get_option('smtp2go_from_name') . '<' . get_option('smtp2go_from_address') . '>');
        $this->setCustomHeaders(get_option('smtp2go_custom_headers'));
    }

    /**
     * Send the request to the api via a WP_HTTP instance
     *
     * @since 1.0.0
     * @return Wp_Error|array
     */
    public function send(WP_Http $http)
    {
        return $http->post($this->endpoint, $this->buildRequest());
    }

    public function buildRequest()
    {
        /** the body of the request which will be sent as json */
        $body = array();

        $body['api_key']        = $this->getApiKey();
        $body['to']             = $this->buildRecipientsArray();
        $body['sender']         = $this->getSender();
        $body['html_body']      = $this->getMessage();
        $body['custom_headers'] = $this->buildCustomHeadersArray();
        $body['subject']        = $this->getSubject();
        $request_headers        = array(array('Content-Type' => 'application/json'));

        return array(
            'headers' => $request_headers,
            'method'  => 'POST',
            'body'    => json_encode($body),
        );

        /*
    {
    "api_key": "api-40246460336B11E6AA53F23C91285F72",
    "to": ["Test Person <test@example.com>"],
    "sender": "Test Persons Friend <test2@example.com>",
    "subject": "Hello Test Person",
    "text_body": "You're my favorite test person ever",
    "html_body": "<h1>You're my favorite test person ever</h1>",
    "custom_headers": [
    {
    "header": "Reply-To",
    "value": "Actual Person <test3@example.com>"
    }
    ],
    "attachments": [
    {
    "filename": "test.pdf",
    "fileblob": "--base64-data--",
    "mimetype": "application/pdf"
    },
    {
    "filename": "test.txt",
    "fileblob": "--base64-data--",
    "mimetype": "text/plain"
    }

     */
    }

    public function buildCustomHeadersArray()
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
        return $custom_headers;
    }
    /**
     * create an array of recipients to send to the api
     * @todo check how these are formatted and parse appropriately
     * @return void
     */
    public function buildRecipientsArray()
    {
        $recipients = array();

        //parse the way wp_email gets data into the "fname lname email"  format;
        if (!is_array($this->recipients)) {
            $recipients[] = $this->recipients;
        } else {
            foreach ($this->recipients as $recipient_item) {
                //@todo check how these are formatted and parse appropriately
                $recipients[] = trim($recipient_item);
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
     * Get the api key
     *
     * @return  string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * Set the api key
     *
     * @param  string  $api_key  The api key
     *
     * @return  self
     */
    public function setApiKey(string $api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * Get custom headers
     *
     * @return  array
     */
    public function getCustomHeaders()
    {
        return $this->custom_headers;
    }

    /**
     * Set custom headers
     *
     * @param  array  $custom_headers  Custom headers
     *
     * @return  self
     */
    public function setCustomHeaders(array $custom_headers)
    {
        $this->custom_headers = $custom_headers;

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
     * @param string  $sender RFC-822 formatted email "John Smith <john@example.com>"
     *
     * @return self
     */
    public function setSender(string $sender)
    {
        $this->sender = $sender;

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
     * @return  string|array
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
        $this->recipients = $recipients;

        return $this;
    }
}
