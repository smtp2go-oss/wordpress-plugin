<?php
namespace SMTP2GO;

use PHPMailer\PHPMailer\PHPMailer;
use SMTP2GO\ApiClient;
use SMTP2GO\Api\ApiRequest;
use SMTP2GO\Senders\SendsHttpRequests;
use SMTP2GO\Service\Mail\Send;

require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
require_once dirname(__FILE__, 2) . '/vendor/vendor/autoload.php';
class SMTP2GOMailer extends PHPMailer
{
    /**
     * The arguments passed by wp_mail
     *
     * @var [type]
     */
    public $wp_args;

    /**
     * The last ApiRequest Object
     *
     * @var ApiRequest
     */
    protected $last_request = null;

    protected $sender = null;

    public function setSenderInstance(SendsHttpRequests $sender)
    {
        $this->sender = $sender;
    }

    public function getSenderInstance()
    {
        return $this->sender;
    }

    protected function mailSend($header, $body)
    {
        $from = [get_option('smtp2go_from_address'), get_option('smtp2go_from_name')];

        $mailSend = new Send(
            $from,
            $this->getToAddresses(),
            $this->Subject,
            $this->Body,
        );

        $mailSend->setCustomHeaders(get_option('smtp2go_custom_headers'));

        $mailSend->setBcc($this->getBccAddresses());
        $mailSend->setCc($this->getCcAddresses());

        if (!empty($this->getAttachments())) {
            $attachments = [];
            foreach ($this->getAttachments() as $phpmailerAttachementItem) {
                $attachments[] = $phpmailerAttachementItem[0];
            }
            $mailSend->setAttachments($attachments);
        }

        if (!empty($this->AltBody)) {
            $mailSend->setTextBody($this->AltBody);
        }
        /*we dont want the wp_mail default to override our configured options,
        only other plugins. There doesnt seem to be a nicer way to detect this.*/
        if ($this->FromName != 'WordPress') {
            $mailSend->setSender($this->From, $this->FromName);
        }

        $client = new ApiClient(get_option('smtp2go_api_key'));

        $success            = $client->consume($mailSend);
        $this->last_request = $client;

        return $success;
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

        return $compat->processAttachments($wp_attachments);
    }

    public function getLastRequest()
    {
        return $this->last_request;
    }
}
