<?php
namespace Tests\Unit;

require_once 'SMTP2GO-class-loader.php';
use SMTP2GO\Api\ApiMessage;
use PHPUnit\Framework\TestCase;

class ApiMessageTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    private function createTestInstance()
    {
        $message = new ApiMessage(['Test User <mail@example.local>'], 'Test Message', '');

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

        $this->assertEquals($message->getSender(), '"Unit Test" <unit@test.fake>');
    }

    public function testMessageBodyIsSet()
    {
        $test_string = '<h1>Hello World</h1>';
        $message     = $this->createTestInstance();
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

        $formatted_headers = $message->buildCustomHeaders();

        $this->assertArrayHasKey('header', $formatted_headers[0]);
        $this->assertArrayHasKey('value', $formatted_headers[0]);
    }

    public function testbuildRequestPayloadWithHTMLMessage()
    {
        $expected_json_body_string = '{"to":["Test Recipient <test@example.fake>"],"sender":"\"Unit Test\" <unit@test.fake>","html_body":"<html><body><h1>Heading<\/h1><div>This is the message<\/div><\/body><\/html>","custom_headers":[{"header":"X-Test-Header","value":"Testing"}],"subject":"Test Message"}';
        $message                   = $this->createTestInstance();

        $message->setSubject('Test Message');
        $message->setMessage('<html><body><h1>Heading</h1><div>This is the message</div></body></html>');
        $message->setRecipients('Test Recipient <test@example.fake>');
        $message->setContentType('text/html');
        $request_data = $message->buildRequestPayload();

        $this->assertArrayHasKey('body', $request_data);
        $this->assertArrayHasKey('method', $request_data);

        $this->assertJsonStringEqualsJsonString($expected_json_body_string, json_encode(array_filter($request_data['body'])));
    }

    public function testbuildRequestPayloadWithTextMessage()
    {
        $expected_json_body_string = '{"to":["Test Recipient <test@example.fake>"],"sender":"\"Unit Test\" <unit@test.fake>","text_body":"This is the message","custom_headers":[{"header":"X-Test-Header","value":"Testing"}],"subject":"Test Message"}';
        $message                   = $this->createTestInstance();

        $message->setSubject('Test Message');
        $message->setMessage('This is the message');
        $message->setRecipients('Test Recipient <test@example.fake>');

        $request_data = $message->buildRequestPayload();

        $this->assertArrayHasKey('body', $request_data);
        $this->assertArrayHasKey('method', $request_data);

        $this->assertJsonStringEqualsJsonString($expected_json_body_string, json_encode(array_filter($request_data['body'])));
    }

    public function testAddAttachment()
    {
        $message = $this->createTestInstance();

        $message->setAttachments(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $request_data = $message->buildRequestPayload();

        $this->assertArrayHasKey('attachments', $request_data['body']);

        $this->assertEquals('image/jpeg', $request_data['body']['attachments'][0]['mimetype']);
    }

    public function testAddInline()
    {
        $message = $this->createTestInstance();

        $message->setInlines(dirname(__FILE__, 2) . '/Attachments/cat.jpg');

        $request_data = $message->buildRequestPayload();

        $this->assertArrayHasKey('inlines', $request_data['body']);

        $this->assertEquals('image/jpeg', $request_data['body']['inlines'][0]['mimetype']);
    }
}
