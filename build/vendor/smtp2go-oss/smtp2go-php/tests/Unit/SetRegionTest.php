<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\GuzzleHttp\Client;
use SMTP2GOWPPlugin\GuzzleHttp\HandlerStack;
use SMTP2GOWPPlugin\GuzzleHttp\Handler\MockHandler;
use SMTP2GOWPPlugin\GuzzleHttp\Psr7\Response;
use SMTP2GOWPPlugin\PHPUnit\Framework\TestCase;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Service;
class SetRegionTest extends TestCase
{
    /**
     * @covers  \SMTP2GO\Service\Service
     * @covers \SMTP2GO\ApiClient
     * @return void
     */
    public function testSetRegion()
    {
        $client = new ApiClient(\SMTP2GOWPPlugin\SMTP2GO_API_KEY);
        $client->setApiRegion('eu');
        $this->assertEquals('eu', $client->getApiRegion());
    }
    /**
     * @covers  \SMTP2GO\Service\Service
     * @covers \SMTP2GO\ApiClient
     * @return void
     */
    public function testGetApiUrlUsesTheRegionSetByTheUser()
    {
        $client = new ApiClient(\SMTP2GOWPPlugin\SMTP2GO_API_KEY);
        $client->setApiRegion('eu');
        $this->assertEquals('https://eu-api.smtp2go.com/v3/', $client->getApiUrl());
    }
    /**
     * @covers  \SMTP2GO\Service\Service
     * @covers \SMTP2GO\ApiClient
     * @return void
     */
    public function testGetApiUrlUsesTheDefaultUrlWhenNoRegionIsSet()
    {
        $client = new ApiClient(\SMTP2GOWPPlugin\SMTP2GO_API_KEY);
        $this->assertEquals(ApiClient::API_URL, $client->getApiUrl());
    }
    /**
     * @covers  \SMTP2GO\Service\Service
     * @covers \SMTP2GO\ApiClient
     * @return void
     */
    public function testSetRegionThrowsExceptionWhenInvalidRegionIsPassed()
    {
        $client = new ApiClient(\SMTP2GOWPPlugin\SMTP2GO_API_KEY);
        $this->expectException(\InvalidArgumentException::class);
        $client->setApiRegion('nz');
    }
}
