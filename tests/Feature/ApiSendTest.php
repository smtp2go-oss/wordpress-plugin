<?php
namespace Tests\Feature;

require_once 'SMTP2GO-class-loader.php';

use PHPUnit\Framework\TestCase;
use SMTP2GO\ApiMessage;
use SMTP2GO\ApiRequest;

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
        $message = new ApiMessage(SMTP2GO_TEST_RECIPIENT, 'Test Message', '');

        $message->setSender(SMTP2GO_TEST_SENDER);

        return $message;
    }

    public function testSendHtmlEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('<html><body><h1>Hello World</h1><p>Cat.</p></body></html>');

        $email->setInlines(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $email->setContentType('text/html');

        $api_request = new ApiRequest(SMTP2GO_API_KEY);

        //for tests we want to avoid trying to pull in wordpress classes
        $api_request->setSendMethod('curl');

        $this->assertTrue($api_request->send($email));
    }

    public function testSendPlainTextEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('This is a plain text email' . str_repeat(PHP_EOL, 5));

        $email->setAttachments(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $api_request = new ApiRequest(SMTP2GO_API_KEY);

        $api_request->setSendMethod('curl');

        $email->setContentType('text/plain');

        $this->assertTrue($api_request->send($email));
    }

    public function testSendEmailThroughApiWithInvalidPayloadReturnsFalse()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('');//invalid, must have a message

        $api_request = new ApiRequest(SMTP2GO_API_KEY);

        $api_request->setSendMethod('curl');
        
        $this->assertFalse($api_request->send($email));
    }
}
