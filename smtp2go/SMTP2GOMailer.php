<?php
namespace SMTP2GO;

use PHPMailer\PHPMailer\PHPMailer;

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
        
        $SMTP2GOmessage->setSender($this->From, $this->FromName);

        $SMTP2GOmessage->setContentType($this->ContentType);

        $request = new ApiRequest;

        return $request->send($SMTP2GOmessage);
    }
}
