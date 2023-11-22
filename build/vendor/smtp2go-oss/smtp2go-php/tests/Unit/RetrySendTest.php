<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\GuzzleHttp\Client;
use SMTP2GOWPPlugin\GuzzleHttp\HandlerStack;
use SMTP2GOWPPlugin\GuzzleHttp\Handler\MockHandler;
use SMTP2GOWPPlugin\GuzzleHttp\Psr7\Response;
use SMTP2GOWPPlugin\PHPUnit\Framework\TestCase;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Service;
class RetrySendTest extends TestCase
{
    /**
     * @covers  \SMTP2GO\Service\Service
     * @covers \SMTP2GO\ApiClient
     * @return void
     */
    public function test_setting_retry()
    {
        //@todo this needs to use a mock handler rather than a real api call
        $expectedResponse = '{"request_id": "65e68938-c332-11eb-8a00-f23c9216ceac", "data": {"emails": 56, "rejects": 0, "softbounces": 4, "hardbounces": 0, "bounce_percent": "7.14"}}';
        $mockResponses = new MockHandler([new Response(503, [], 'Service Unavailable'), new Response(200, [], $expectedResponse)]);
        $handler = HandlerStack::create($mockResponses);
        $httpClient = new Client(['handler' => $handler]);
        $service = new Service('stats/email_bounces');
        $apiClient = new ApiClient(\SMTP2GOWPPlugin\SMTP2GO_API_KEY);
        $apiClient->setHttpClient($httpClient);
        $apiClient->setRequestOptions(['verify' => \false]);
        $apiClient->setMaxSendAttempts(2);
        $apiClient->setTimeout(2);
        $apiClient->setTimeoutIncrement(1);
        $result = $apiClient->consume($service);
        $this->assertTrue($result);
        $this->assertNotEmpty($apiClient->getApiServerIps(\false));
        $this->assertEquals(1, $apiClient->getFailedAttempts());
        // $this->assertTrue();
    }
}
