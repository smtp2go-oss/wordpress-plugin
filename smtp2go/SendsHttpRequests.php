<?php

namespace SMTP2GO;

interface SendsHttpRequests
{
    /**
     * Send an http request to a specified url
     * @param string $url
     * @param array $payload
     * @return bool
     */
    public function send(string $url, array $payload):bool;
    public function getLastResponse();
    public function getFailures();

}
