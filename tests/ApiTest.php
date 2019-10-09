<?php
declare(strict_types=1);

require_once 'includes/class-smtp2go-api.php';

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{

    public function __construct()
    {
        parent::__construct();
    }

    private function createTestInstance()
    {
        $api = new Smtp2GoApi(['Test User <mail@example.local>'], 'Test Message', '');

        $raw_headers = unserialize('a:2:{s:6:"header";a:1:{i:0;s:13:"X-Test-Header";}s:5:"value";a:1:{i:0;s:7:"Testing";}}');

        $api->setCustomHeaders($raw_headers);

        $api->setSender('unit@test.fake', 'Unit Test');

        return $api;
    }

    public function testSetMessage()
    {
        $test_string = '<h1>Hello World</h1>';
        $api = $this->createTestInstance();
        $api->setMessage($test_string);
        $this->assertEquals($api->getMessage(), $test_string);
    }

    /**
     * Tests custom headers are built into the correct format for the api
     *
     * @return void
     */
    public function testBuildCustomHeaders()
    {
        //use the same stored format

        $api = $this->createTestInstance();

        $formatted_headers = $api->buildCustomHeadersArray();

        $this->assertArrayHasKey('header', $formatted_headers[0]);
        $this->assertArrayHasKey('value', $formatted_headers[0]);
    }

    public function testBuildRequest()
    {
        $expected_json_body_string = '{"api_key":"api-fake-key","to":["Test Recipient <test@example.fake>"],"sender":"Unit Test <unit@test.fake>","html_body":"<h1>Heading<\/h1><div>This is the message<\/div>","custom_headers":[{"header":"X-Test-Header","value":"Testing"}],"subject":"Test Message"}';
        $api = $this->createTestInstance();

        $api->setSubject('Test Message');
        $api->setMessage('<h1>Heading</h1><div>This is the message</div>');
        $api->setRecipients('Test Recipient <test@example.fake>');
        $api->setApiKey('api-fake-key');

        $request_data = $api->buildRequest();

        $this->assertArrayHasKey('body', $request_data);
        $this->assertArrayHasKey('headers', $request_data);
        $this->assertArrayHasKey('method', $request_data);

        $this->assertJsonStringEqualsJsonString($expected_json_body_string, $request_data['body']);
    }
}