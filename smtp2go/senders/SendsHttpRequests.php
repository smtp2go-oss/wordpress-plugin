<?php

namespace SMTP2GO\Senders;

interface SendsHttpRequests
{
    /**
     * Send an http request to a specified url
     * @param string $url
     * @param array $payload
     * @return bool
     */
    public function send(string $url, array $payload): bool;
    
    /**
     * Return the last response object from the SMTP2GO Api
     *
     * @return \stdClass
     */
    public function getLastResponse();

    /**
     * Return the failures array from the last SMTP2GO Api call
     *
     * @return array
     */
    public function getFailures();
}
