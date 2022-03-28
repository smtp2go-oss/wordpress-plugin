<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\PHPUnit\Framework\Exception;
use SMTP2GOWPPlugin\PHPUnit\Framework\ExpectationFailedException;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;
use SMTP2GOWPPlugin\PHPUnit\Framework\TestCase;
use SMTP2GOWPPlugin\SebastianBergmann\RecursionContext\InvalidArgumentException;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\Address;
use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\CustomHeader;
use SMTP2GOWPPlugin\SMTP2GO\Collections\Mail\AddressCollection;
use SMTP2GOWPPlugin\SMTP2GO\Collections\Mail\CustomHeaderCollection;
/**
* @covers \SMTP2GO\Service\Mail\Send
* @covers \SMTP2GO\Collections\Collection::current
* @covers \SMTP2GO\Collections\Collection::next
* @covers \SMTP2GO\Collections\Collection::rewind
* @covers \SMTP2GO\Collections\Collection::valid
* @covers \SMTP2GO\Collections\Mail\AddressCollection::__construct
* @covers \SMTP2GO\Collections\Mail\AddressCollection::add
* @covers \SMTP2GO\Collections\Mail\AttachmentCollection::__construct
* @covers \SMTP2GO\Collections\Mail\CustomHeaderCollection::__construct
* @covers \SMTP2GO\Types\Mail\Address::__construct
* @covers \SMTP2GO\Types\Mail\Address::getEmail
* @covers \SMTP2GO\Types\Mail\Address::getName
* @covers \SMTP2GO\Collections\Mail\CustomHeaderCollection::add
* @covers \SMTP2GO\Types\Mail\CustomHeader::__construct
*/
class SendSettersTest extends TestCase
{
    /**
     * Sender
     * @var Send
     */
    private $sender;
    public function setUp() : void
    {
        $this->sender = new Send(new Address('test@test.test'), new AddressCollection([new Address('recipient@test.test')]), 'Testing!', 'Test Message');
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws InvalidArgumentException 
     * @throws Exception 
     * @throws ExpectationFailedException 
     */
    public function testSettingBcc()
    {
        $this->sender->setBcc(new AddressCollection([new Address('bcc@test.test')]));
        $this->assertContains('bcc@test.test', $this->sender->getBcc());
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws InvalidArgumentException 
     * @throws Exception 
     * @throws ExpectationFailedException 
     */
    public function testAddingBcc()
    {
        $this->sender->addAddress('bcc', new Address('bcc@test.test'));
        $this->assertContains('bcc@test.test', $this->sender->getBcc());
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws InvalidArgumentException 
     * @throws Exception 
     * @throws ExpectationFailedException 
     */
    public function testSettingcc()
    {
        $this->sender->setCc(new AddressCollection([new Address('cc@test.test')]));
        $this->assertContains('cc@test.test', $this->sender->getcc());
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws InvalidArgumentException 
     * @throws Exception 
     * @throws ExpectationFailedException 
     */
    public function testAddingcc()
    {
        $this->sender->addAddress('cc', new Address('cc@test.test'));
        $this->assertContains('cc@test.test', $this->sender->getcc());
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testSettingTextBody()
    {
        $this->sender->setTextBody('Test Message');
        $this->assertEquals('Test Message', $this->sender->getTextBody());
    }
    /**
     * @return void 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testSettingCustomHeaders()
    {
        $headers = new CustomHeaderCollection([new CustomHeader('X-SENT-BY', 'SMTP2GO-PHPUnit')]);
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
* @covers \SMTP2GO\Collections\Collection::current
* @covers \SMTP2GO\Collections\Collection::next
* @covers \SMTP2GO\Collections\Collection::rewind
* @covers \SMTP2GO\Collections\Collection::valid
* @covers \SMTP2GO\Collections\Mail\AddressCollection::__construct
* @covers \SMTP2GO\Collections\Mail\AddressCollection::add
* @covers \SMTP2GO\Collections\Mail\AttachmentCollection::__construct
* @covers \SMTP2GO\Collections\Mail\CustomHeaderCollection::__construct
* @covers \SMTP2GO\Types\Mail\Address::__construct
* @covers \SMTP2GO\Types\Mail\Address::getEmail
* @covers \SMTP2GO\Types\Mail\Address::getName
* @covers \SMTP2GO\Collections\Mail\CustomHeaderCollection::add
* @covers \SMTP2GO\Types\Mail\CustomHeader::__construct
*/
\class_alias('SMTP2GOWPPlugin\\SendSettersTest', 'SendSettersTest', \false);
