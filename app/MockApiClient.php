<?php
namespace SMTP2GO\App;

use SMTP2GOWPPlugin\GuzzleHttp\Client;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\GuzzleHttp\HandlerStack;
use SMTP2GOWPPlugin\GuzzleHttp\Psr7\Response;
use SMTP2GOWPPlugin\GuzzleHttp\Handler\MockHandler;
use SMTP2GOWPPlugin\GuzzleHttp\Psr7\Utils;

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
              "email_id": "1er8bV-6Tw0Mi-7K",
              "failed": 0,
              "failures": [],
              "succeeded": 1
            },
            "request_id": "aa253464-0bd0-467a-b24b-6159dcd7be60"
          }
EOF;
        
        $stream = Utils::streamFor($mockResponse);

        $mock = new MockHandler([
            new Response(200, ['X-SENT-BY', 'WP-SMTP2GO'], $stream),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient   = new \SMTP2GOWPPlugin\GuzzleHttp\Client(['handler' => $handlerStack]);


        $client  = new ApiClient($this->apiKey);
        $client->setHttpClient($httpClient);

        $client->consume($service);

        $this->lastResponse = $client->getLastResponse();

        return true;
    }
}
