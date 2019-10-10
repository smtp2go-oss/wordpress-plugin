<?php
declare (strict_types = 1);

require_once 'includes/class-smtp2go-api-message.php';
require_once 'includes/class-smtp2go-api-request.php';

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
        $message = new Smtp2GoApiMessage(SMTP2GO_TEST_RECIPIENT, 'Test Message', '');

        $message->setApiKey(SMTP2GO_API_KEY);

        $message->setSender(SMTP2GO_TEST_SENDER);

        return $message;
    }

    public function testSendEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('<h1>Hell\'o World</h1><p>Meet my cat.</p>');

        $email->setAttachments(dirname(dirname(__FILE__)) . '/Attachments/cat.jpg');

        $api_request = new Smtp2GoApiRequest;

        $this->assertTrue($api_request->send($email));
    }

    public function testSendEmailThroughApiWithInvalidPayloadReturnsFalse()
    {
        $email = $this->createTestMessageInstance();

        $email->setMessage('');

        $api_request = new Smtp2GoApiRequest;

        $this->assertFalse($api_request->send($email));
    }

}
