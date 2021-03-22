<?php
namespace Tests\Feature;

require_once 'SMTP2GO-class-loader.php';
use PHPUnit\Framework\TestCase;
use SMTP2GO\CurlSender;
use SMTP2GO\SMTP2GOMailer;

define('ABSPATH', dirname(__FILE__, 6) . '/');
define('WPINC', 'wp-includes');

require dirname(__FILE__, 2) . '/bootstrap.php';

require ABSPATH . WPINC . '/pluggable.php';

class SMTP2GOMailerTest extends TestCase
{


    private function setupMailer()
    {
        $mailer  = new SMTP2GOMailer;
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
        Test Send HTML
        </body>
        </html>';

        $mailer->wp_args = [
            'to'      => SMTP2GO_TEST_RECIPIENT,
            'subject' => 'Test Send',
            'message' => $message,
            'headers' => '',
        ];

        $sender = new CurlSender;
        $mailer->setSenderInstance($sender);

        $mailer->addAddress(SMTP2GO_TEST_RECIPIENT_EMAIL);

        $mailer->From     = SMTP2GO_TEST_SENDER_EMAIL;
        $mailer->FromName = SMTP2GO_TEST_SENDER_NAME;
        $mailer->Body     = $message;

        $mailer->isHTML(true);
        return $mailer;

    }

    public function testCreateInstance()
    {
        $mailer = new SMTP2GOMailer;
        $mailer->setSenderInstance(new CurlSender);
        $this->assertTrue(is_object($mailer));
    }

    public function testSend()
    {
        $mailer = $this->setupMailer();

        $result              = $mailer->send();

        $this->assertTrue($result);

        $this->assertTrue($mailer->getSenderInstance()->getLastResponse()->data->succeeded == 1);

    }

    public function testSendWithWpMail()
    {
        // global $phpmailer;
        $GLOBALS['phpmailer'] = $this->setupMailer();
        $result = wp_mail(SMTP2GO_TEST_RECIPIENT, 'Test Send With WP MAIL', 'Test Plain Send With WP MAIL', '', array());
        $this->assertTrue($result);
        $this->assertTrue($GLOBALS['phpmailer']->getSenderInstance()->getLastResponse()->data->succeeded == 1);

    }
}
