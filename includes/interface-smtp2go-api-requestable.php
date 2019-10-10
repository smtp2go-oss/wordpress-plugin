<?php

/**
 * Defines required behaviour to send a request through the Smtp2GoApiRequest class
 * @since 1.0.0
 */
interface SmtpApi2GoRequestable
{
    public function getEndpoint();
    public function buildRequestPayload();
}