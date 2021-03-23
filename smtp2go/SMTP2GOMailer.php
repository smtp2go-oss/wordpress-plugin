<?php
namespace SMTP2GO;

use PHPMailer\PHPMailer\PHPMailer;
use SMTP2GO\Api\ApiMessage;
use SMTP2GO\Api\ApiRequest;
use SMTP2GO\Senders\SendsHttpRequests;
use SMTP2GO\Senders\WordpressHttpRemotePostSender;

require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';

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
        $SMTP2GOmessage = new ApiMessage(
            $this->wp_args['to'],
            $this->wp_args['subject'],
            $this->wp_args['message'],
            $this->wp_args['headers']
        );

        $SMTP2GOmessage->initFromOptions();

        if (!empty($this->getAttachments())) {
            $SMTP2GOmessage->setMailerAttachments($this->getAttachments());
        }

        if (!empty($this->AltBody)) {
            $SMTP2GOmessage->setAltMessage($this->AltBody);
        }
        //we dont want the wp_mail default to override our configured options
        //only other plugins. There doesnt seem to be a nicer way to detect this.
        if ($this->FromName != 'WordPress') {
            $SMTP2GOmessage->setSender($this->From, $this->FromName);
        }

        $SMTP2GOmessage->setContentType($this->ContentType);

        $request = new ApiRequest;
        if (!$this->sender) {
            $this->sender = new WordpressHttpRemotePostSender;
        }
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log('sending via ' . get_class($this->sender));
        }
        $result = $request->send($SMTP2GOmessage, $this->sender);

        $this->last_request = $request;

        return $result;
    }

    public function getLastRequest()
    {
        return $this->last_request;
    }
}
