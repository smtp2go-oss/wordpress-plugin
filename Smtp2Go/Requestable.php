<?php
namespace Smtp2Go;

/**
 * Defines required behaviour to send a request through the Smtp2GoApiRequest class
 * @since 1.0.0
 */
interface Requestable
{
    public function getEndpoint();
    public function buildRequestPayload();
}