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
        
        //at this point the attachments are already parsed, this method
        //has all the info we need, we'll probably need to add a new method
        //to ApiMessage that understands the format they're in so they can
        //be formatted correctly for the api call
        
        SMTP2GO_dd($this->getAttachments());

        $SMTP2GOmessage = new ApiMessage(
            $this->to,
            $this->Subject,
            $body,
            $this->getCustomHeaders(),
            $this->getAttachments()
        );
        $SMTP2GOmessage->initFromOptions();

        if (!empty($this->AltBody)) {
            $SMTP2GOmessage->setAltMessage($this->AltBody);
        }

        $SMTP2GOmessage->setSender($this->From, $this->FromName);

        $SMTP2GOmessage->setContentType($this->ContentType);

        $request = new ApiRequest;
        //SMTP2GO_dd($SMTP2GOmessage);
        return $request->send($SMTP2GOmessage);
    }
}
