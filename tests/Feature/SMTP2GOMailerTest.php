<?php
namespace Tests\Feature;

require_once 'SMTP2GO-class-loader.php';
use PHPUnit\Framework\TestCase;
use SMTP2GO\Senders\CurlSender;
use SMTP2GO\Senders\WordpressHttpRemotePostSender;
use SMTP2GO\SMTP2GOMailer;

require_once dirname(__FILE__, 2) . '/bootstrap.php';

require_once ABSPATH . WPINC . '/pluggable.php';

class SMTP2GOMailerTest extends TestCase
{
    public function setUp(): void
    {
        $GLOBALS['senderClassName'] = CurlSender::class;
    }

    private function setupMailer($subject = 'Test Send')
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
        <h1>Test Send</h1>
        <p>This is an HTML email</p>
        </body>
        </html>';

        $mailer->wp_args = [
            'to'      => SMTP2GO_TEST_RECIPIENT,
            'subject' => $subject,
            'message' => $message,
            'headers' => array('Content-Type: text/html; charset=UTF-8'),
        ];

        $sender = new CurlSender;
        $mailer->setSenderInstance($sender);

        $mailer->addAddress(SMTP2GO_TEST_RECIPIENT_EMAIL);

        $mailer->From     = SMTP2GO_TEST_SENDER_EMAIL;
        $mailer->FromName = SMTP2GO_TEST_SENDER_NAME;
        $mailer->Body     = $message;
        $mailer->Subject  = $subject;
        $mailer->addAttachment(dirname(__FILE__, 2) . '/Attachments/cat.jpg', 'attachment.jpg');
        $mailer->isHTML(true);
        return $mailer;

    }

    public function testCreateInstance()
    {
        $mailer = new SMTP2GOMailer;
        $mailer->setSenderInstance(new CurlSender);
        $this->assertTrue(is_object($mailer));
    }

    public function testSendWithCurlSender()
    {
        $mailer = $this->setupMailer();

        $result = $mailer->send();
        
        $this->assertTrue($result);

        $this->assertTrue($mailer->getSenderInstance()->getLastResponse()->data->succeeded == 1);

    }

    public function testSendWithFakeWpRemotePostFunctionWhichActuallyJustUsesCurlSender()
    {
        $mailer = $this->setupMailer('Remote HTTP Test');
        $mailer->setSenderInstance(new WordpressHttpRemotePostSender);
        $result = $mailer->send();
        $this->assertTrue($mailer->getSenderInstance()->getLastResponse()->data->succeeded == 1);
    }

    public function testSendWithWpMail()
    {
        $GLOBALS['phpmailer'] = $this->setupMailer();
        $result               = wp_mail(SMTP2GO_TEST_RECIPIENT, 'Test Send With WP MAIL', 'Test Plain Send With WP MAIL', '', array('Content-Type: text/html; charset=UTF-8'));
        $this->assertTrue($result);
        $this->assertTrue($GLOBALS['phpmailer']->getSenderInstance()->getLastResponse()->data->succeeded == 1);

    }
}
