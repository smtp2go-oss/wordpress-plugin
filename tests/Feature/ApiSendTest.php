<?php
declare (strict_types = 1);

require_once 'includes/interface-smtp2go-api-requestable.php';
require_once 'includes/class-smtp2go-api-message.php';
require_once 'includes/class-smtp2go-api-request.php';
require_once 'includes/class-smtp2go-mimetype-helper.php';
require_once 'includes/class-smtp2go-wpmail-compat.php';


use PHPUnit\Framework\TestCase;

/**
 * The constants used in these tests must be declared in your phpunit.xml
 * and tailored to your individual details
 */

class ApiSendTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    private function createTestMessageInstance()
    {
        $message = new Smtp2Go\Smtp2GoApiMessage(SMTP2GO_TEST_RECIPIENT, 'Test Message', '');

        $message->setSender(SMTP2GO_TEST_SENDER);

        return $message;
    }

    public function testSendHtmlEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('<html><body><h1>Hello World</h1><p>Cat.</p></body></html>');

        $email->setAttachments(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $api_request = new Smtp2Go\Smtp2GoApiRequest(SMTP2GO_API_KEY);

        $api_request->setApiKey(SMTP2GO_API_KEY);

        $this->assertTrue($api_request->send($email));
    }

    public function testSendPlainTextEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('This is a plain text email' . str_repeat(PHP_EOL, 5));

        $email->setAttachments(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $api_request = new Smtp2Go\Smtp2GoApiRequest(SMTP2GO_API_KEY);

        $api_request->setApiKey(SMTP2GO_API_KEY);

        $this->assertTrue($api_request->send($email));
    }

    public function testSendEmailThroughApiWithInvalidPayloadReturnsFalse()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('');

        $api_request = new Smtp2Go\Smtp2GoApiRequest(SMTP2GO_API_KEY);

        $this->assertFalse($api_request->send($email));
    }

}
