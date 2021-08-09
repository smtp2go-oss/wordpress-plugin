<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\PHPUnit\Framework\TestCase;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;
/**
 * @covers \SMTP2GO\Service\Mail\Send
 */
class SendSettersTest extends TestCase
{
    /**
     * Sender
     *
     * @var Send
     */
    private $sender;
    public function setUp() : void
    {
        $this->sender = new Send(['test@test.test'], ['recipient@test.test'], 'Testing!', 'Test Message');
    }
    public function testSettingBcc()
    {
        $this->sender->setBcc([['bcc@test.test']]);
        $this->assertContains('bcc@test.test', $this->sender->getBcc());
    }
    public function testAddingBcc()
    {
        $this->sender->addAddress('bcc', 'bcc@test.test');
        $this->assertContains('bcc@test.test', $this->sender->getBcc());
    }
    public function testSettingcc()
    {
        $this->sender->setcc([['cc@test.test']]);
        $this->assertContains('cc@test.test', $this->sender->getcc());
    }
    public function testAddingcc()
    {
        $this->sender->addAddress('cc', 'cc@test.test');
        $this->assertContains('cc@test.test', $this->sender->getcc());
    }
    public function testSettingTextBody()
    {
        $this->sender->setTextBody('Test Message');
        $this->assertEquals('Test Message', $this->sender->getTextBody());
    }
    public function testSettingCustomHeaders()
    {
        $headers = [['header' => 'headerName', 'value' => 'headerValue']];
        $this->sender->setCustomHeaders($headers);
        $this->assertEquals($headers, $this->sender->getCustomHeaders());
    }
    public function testGetMethod()
    {
        $this->assertEquals('POST', $this->sender->getMethod());
    }
    public function testGetEndpoint()
    {
        $this->assertEquals('email/send', $this->sender->getEndpoint());
    }
}
/**
 * @covers \SMTP2GO\Service\Mail\Send
 */
\class_alias('SMTP2GOWPPlugin\\SendSettersTest', 'SendSettersTest', \false);
