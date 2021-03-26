<?php
namespace Tests\Unit;

require_once 'SMTP2GO-class-loader.php';
use PHPUnit\Framework\TestCase;
use SMTP2GO\Senders\MockSender;
use SMTP2GO\SMTP2GOMailer;



require_once dirname(__FILE__, 2) . '/bootstrap.php';

require_once ABSPATH . WPINC . '/pluggable.php';
class SMTP2GOMailerTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setUp(): void
    {
        $GLOBALS['senderClassName'] = MockSender::class;
    }

    public function testMultipleAddressesAreAddedWhenSetAsCommaDelimitedString()
    {
        $mailer          = new SMTP2GOMailer;
        $GLOBALS['phpmailer'] = $mailer;


        wp_mail('sender1@test.test,send2@test.test', 'test', 'test', '');
        $this->assertCount(2, $mailer->getToAddresses());
    }

    public function testMultipleAddressesAreAddedWhenSetAsArray()
    {
        $mailer          = new SMTP2GOMailer;
        $GLOBALS['phpmailer'] = $mailer;


        wp_mail(['sender1@test.test','send2@test.test'], 'test', 'test', '');
        $this->assertCount(2, $mailer->getToAddresses());
    }
}
