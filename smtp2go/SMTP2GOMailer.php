<?php
namespace SMTP2GO;

use PHPMailer\PHPMailer\PHPMailer;

require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';

class SMTP2GOMailer extends PHPMailer
{
    public $wp_args;

    protected function mailSend($header, $body)
    {
        // SMTP2GO_dd($body);
        $SMTP2GOmessage = new ApiMessage(
            $this->to[0],
            $this->Subject,
            $this->Body //$body has MIME data in it which we dont want
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
