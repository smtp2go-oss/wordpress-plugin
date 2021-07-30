<?php

namespace SMTP2GO;

use PHPMailer\PHPMailer\PHPMailer;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;

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

    protected function mailSend($header, $body)
    {
        $from = [get_option('smtp2go_from_address'), get_option('smtp2go_from_name')];

        $mailSendService = new Send(
            $from,
            $this->getToAddresses(),
            $this->Subject,
            $this->Body,
        );

        $mailSendService->setCustomHeaders(get_option('smtp2go_custom_headers'));

        $mailSendService->setBcc($this->getBccAddresses());
        $mailSendService->setCc($this->getCcAddresses());

        $mailSendService->addAddresses('reply-to', $this->getReplyToAddresses());

        if (!empty($this->getAttachments())) {
            $attachments = [];
            foreach ($this->getAttachments() as $phpmailerAttachementItem) {
                $attachments[] = $phpmailerAttachementItem[0];
            }
            $mailSendService->setAttachments($attachments);
        }

        if (!empty($this->AltBody)) {
            $mailSendService->setTextBody($this->AltBody);
        }
        /*we dont want the wp_mail default to override our configured options,
        only other plugins. There doesnt seem to be a nicer way to detect this.*/
        if ($this->FromName != 'WordPress') {
            $mailSendService->setSender($this->From, $this->FromName);
        }

        $client = new ApiClient(get_option('smtp2go_api_key'));

        $success            = $client->consume($mailSendService);
        $this->last_request = $client;

        return $success;
    }



    public function getLastRequest()
    {
        return $this->last_request;
    }
}
