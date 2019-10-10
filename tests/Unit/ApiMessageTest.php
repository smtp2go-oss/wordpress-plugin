<?php
declare(strict_types=1);

require_once 'includes/class-smtp2go-api-message.php';

use PHPUnit\Framework\TestCase;

class ApiMessageTest extends TestCase
{

    public function __construct()
    {
        parent::__construct();
    }

    private function createTestInstance()
    {
        $message = new Smtp2GoApiMessage(['Test User <mail@example.local>'], 'Test Message', '');

        $raw_headers = unserialize('a:2:{s:6:"header";a:1:{i:0;s:13:"X-Test-Header";}s:5:"value";a:1:{i:0;s:7:"Testing";}}');

        $message->setCustomHeaders($raw_headers);

        $message->setSender('unit@test.fake', 'Unit Test');

        return $message;
    }

    public function testSubjectIsSetByConstructor()
    {
        $message = $this->createTestInstance();

        $this->assertEquals($message->getSubject(), 'Test Message');
    }

    public function testSenderIsSetByConstructor()
    {
        $message = $this->createTestInstance();

        $this->assertEquals($message->getSender(), 'Unit Test <unit@test.fake>');
    }

    public function testMessageBodyIsSet()
    {
        $test_string = '<h1>Hello World</h1>';
        $message = $this->createTestInstance();
        $message->setMessage($test_string);
        $this->assertEquals($message->getMessage(), $test_string);
    }

    /**
     * Tests custom headers are built into the correct format for the api
     *
     * @return void
     */
    public function testBuildCustomHeaders()
    {
        //use the same stored format

        $message = $this->createTestInstance();

        $formatted_headers = $message->buildCustomHeadersArray();

        $this->assertArrayHasKey('header', $formatted_headers[0]);
        $this->assertArrayHasKey('value', $formatted_headers[0]);
    }

    public function testbuildRequestPayload()
    {
        $expected_json_body_string = '{"api_key":"api-fake-key","to":["Test Recipient <test@example.fake>"],"sender":"Unit Test <unit@test.fake>","html_body":"<h1>Heading<\/h1><div>This is the message<\/div>","custom_headers":[{"header":"X-Test-Header","value":"Testing"}],"subject":"Test Message"}';
        $message = $this->createTestInstance();

        $message->setSubject('Test Message');
        $message->setMessage('<h1>Heading</h1><div>This is the message</div>');
        $message->setRecipients('Test Recipient <test@example.fake>');
        $message->setApiKey('api-fake-key');

        $request_data = $message->buildRequestPayload();

        $this->assertArrayHasKey('body', $request_data);
        $this->assertArrayHasKey('method', $request_data);

        $this->assertJsonStringEqualsJsonString($expected_json_body_string, $request_data['body']);
    }
}