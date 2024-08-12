<?php

namespace SMTP2GO\App;

use PHPMailer\PHPMailer\PHPMailer;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Collections\Mail\AddressCollection;
use SMTP2GOWPPlugin\SMTP2GO\Collections\Mail\AttachmentCollection;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\Address;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\Attachment;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\CustomHeader;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\InlineAttachment;

require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
require_once dirname(__FILE__, 2) . '/build/vendor/autoload.php';
class SMTP2GOMailer extends PHPMailer
{
    /**
     * The arguments passed by wp_mail
     *
     * @var [type]
     */
    public $wp_args;

    /**
     * The last ApiClient Object
     *
     * @var ApiClient
     */
    protected $last_request = null;

    protected $sender = null;

    protected $hasCustomReplyToHeader = false;

    private $apiClient = null;

    protected function mailSend($header, $body)
    {
        $from = [get_option('smtp2go_from_address'), get_option('smtp2go_from_name')];

        $addresses = [];
        foreach ($this->getToAddresses() as $addressItem) {
            $addresses[] = new Address(...$addressItem);
        }
        $mailSendService = new Send(
            new Address(...$from),
            new AddressCollection($addresses),
            $this->Subject,
            $this->Body
        );

        $mailSendService->addCustomHeader(new CustomHeader('X-Smtp2go-WP', SMTP2GO_WORDPRESS_PLUGIN_VERSION));

        $this->processCustomHeaders($mailSendService);
        $this->processReplyTos($mailSendService);

        $bcc = new AddressCollection([]);
        foreach ($this->getBccAddresses() as $addressItem) {
            $bcc->add(new Address(...$addressItem));
        }
        $cc = new AddressCollection([]);
        foreach ($this->getCcAddresses() as $addressItem) {
            $cc->add(new Address(...$addressItem));
        }

        $mailSendService->setBcc($bcc);
        $mailSendService->setCc($cc);

        $mailSendService->setVersion(2);

        /** PhpMailer attachment array structure
         *  0 => $path,
         *   1 => $filename,
         *   2 => $name,
         *   3 => $encoding,
         *   4 => $type,
         *   5 => false, //isStringAttachment
         *   6 => $disposition,
         *   7 => cid,
         */
        if (!empty($this->getAttachments())) {
            $inlines     = new AttachmentCollection;
            $attachments = new AttachmentCollection;
            foreach ($this->getAttachments() as $phpmailerAttachementItem) {
                if (self::fileIsAccessible($phpmailerAttachementItem[0])) {
                    $attachments->add(new Attachment($phpmailerAttachementItem[0]));
                } else {
                    if (!empty($phpmailerAttachementItem[7]) && is_string($phpmailerAttachementItem[7])) {
                        $inlines->add(new InlineAttachment(
                            $phpmailerAttachementItem[7],
                            $phpmailerAttachementItem[0],
                            $phpmailerAttachementItem[4]
                        ));
                    }
                }
            }
            $mailSendService->setAttachments($attachments);
            $mailSendService->setInlines($inlines);
        }

        if (!empty($this->AltBody)) {
            $mailSendService->setTextBody($this->AltBody);
        }
        /*we dont want the wp_mail default to override our configured options,
        only other plugins. There doesnt seem to be a nicer way to detect this.*/

        if ($this->FromName != 'WordPress' && !empty($this->From)) {
            $mailSendService->setSender(new Address($this->From, $this->FromName));
        }

        $apiKey = get_option('smtp2go_api_key');

        $keyHelper = new SecureApiKeyHelper();
        $client = $this->apiClient ?? new ApiClient($keyHelper->decryptKey($apiKey));
        $client->setMaxSendAttempts(2);
        $client->setTimeoutIncrement(0);
        $success            = $client->consume($mailSendService);
        $this->last_request = $client;

        return $success;
    }

    public function setApiClient(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }


    /**
     * Process the headers stored as Wordpress options
     */
    private function processCustomHeaders(Send $mailSendService)
    {
        $raw_custom_headers =  get_option('smtp2go_custom_headers');

        if (!empty($raw_custom_headers['header'])) {
            foreach ($raw_custom_headers['header'] as $index => $header) {
                if (!empty($header) && !empty($raw_custom_headers['value'][$index])) {

                    $mailSendService->addCustomHeader(new CustomHeader($header, $raw_custom_headers['value'][$index]));
                    if (strtolower($header) === 'reply-to') {
                        $this->hasCustomReplyToHeader = true;
                    }
                }
            }
        }
    }

    /**
     * Process PHPMailer reply To Addresses into Reply-To Headers
     *
     * @param Send $mailSendService
     * @return void
     */
    private function processReplyTos(Send $mailSendService)
    {
        $replyTos = $this->getReplyToAddresses();
        $existing = false;
        if ($this->hasCustomReplyToHeader) {
            $customHeaders = $mailSendService->getCustomHeaders();
            /** @var CustomHeader $CustomHeader */
            foreach ($customHeaders as $CustomHeader) {
                if (strtolower($CustomHeader->getHeader()) === 'reply-to') {
                    $existing = $CustomHeader;
                    break;
                }
            }
        }
        foreach ($replyTos as $replyToItem) {
            $email = $replyToItem[0] ?? null;
            $name = $replyToItem[1] ?? '';
            if ($email) {
                if (!$existing) {
                    $existing = new CustomHeader('Reply-To', trim("$name <$email>"));
                    $mailSendService->addCustomHeader($existing);
                } else {
                    /** @var CustomHeader $existing */
                    $existing->setValue($existing->getValue() . ',' . trim("$name <$email>"));
                }
            }
        }
    }



    public function getLastRequest()
    {
        return $this->last_request;
    }
}
