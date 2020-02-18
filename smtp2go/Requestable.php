<?php
namespace SMTP2GO;

/**
 * Defines required behaviour to send a request through the SMTP2GOApiRequest class
 * @since 1.0.1
 * @package    SMTP2GO\WordpressPlugin
 *
 */
interface Requestable
{
    public function getEndpoint();
    public function buildRequestPayload();
}
