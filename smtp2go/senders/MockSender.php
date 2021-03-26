<?php
namespace SMTP2GO\Senders;

use SMTP2GO\Senders\SendsHttpRequests;

/**
 * Sends no requests, used in development for unit tests
 */
class MockSender implements SendsHttpRequests
{
    /**
     * The last response relieved from the api as a json object
     *
     * @var mixed
     */
    protected $last_response;

    /**
     * Meta data about the last response from the api
     *
     * @var mixed
     */
    protected $last_meta;

    /**
     * store the failures data returned from the api
     *
     * @var array
     */
    protected $failures = array();

    /**
     * Send using CURL
     *
     * @param string $url
     * @param array $payload
     * @return bool
     */
    public function send(string $url, array $payload): bool
    {
        return true;
    }

    public function getLastResponse()
    {
        $r = new \stdClass;
        $r->data = new \stdClass;
        $r->data->succeeded = true;
        return $r;
    }

    public function getFailures()
    {
        return $this->failures;
    }
}
