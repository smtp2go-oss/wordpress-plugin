<?php
declare (strict_types = 1);

require_once 'includes/class-smtp2go-api.php';

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

    private function createTestInstance()
    {
        $api = new Smtp2GoApi(SMTP2GO_TEST_RECIPIENT, 'Test Message', '');

        $api->setApiKey(SMTP2GO_API_KEY);

        $api->setSender(SMTP2GO_TEST_SENDER);

        return $api;
    }

    public function testSendEmailThroughApiWithValidPayloadReturnsTrue()
    {
        $api = $this->createTestInstance();

        $api->setMessage('<h1>Hello World</h1><p>Meet my cat.</p>');

        $api->setAttachments(dirname(dirname(__FILE__)) . '/Attachments/cat.jpg');

        $this->assertTrue($api->send());

    }

}
