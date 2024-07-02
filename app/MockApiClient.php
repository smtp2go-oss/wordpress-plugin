<?php
namespace SMTP2GO\App;

use SMTP2GOWPPlugin\GuzzleHttp\Client;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\GuzzleHttp\HandlerStack;
use SMTP2GOWPPlugin\GuzzleHttp\Psr7\Response;
use SMTP2GOWPPlugin\GuzzleHttp\Handler\MockHandler;


class MockApiClient extends \SMTP2GOWPPlugin\SMTP2GO\ApiClient
{
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
        $this->httpClient = new Client();
    }

    public function consume(\SMTP2GOWPPlugin\SMTP2GO\Contracts\BuildsRequest $service): bool
    {
        $mockResponse = <<<EOF
        {
            "data": {
              "email_id": "1er8bV-6Tw0Mi-7h",
              "failed": 0,
              "failures": [],
              "succeeded": 1
            },
            "request_id": "aa253464-0bd0-467a-b24b-6159dcd7be60"
          }
EOF;

        $mock = new MockHandler([
            new Response(200, ['X-SENT-BY', 'WP-SMTP2GO'], $mockResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient   = new \SMTP2GOWPPlugin\GuzzleHttp\Client(['handler' => $handlerStack]);


        $client  = new ApiClient($this->apiKey);
        $client->setHttpClient($httpClient);

        $client->consume($service);

        return true;
    }
}
