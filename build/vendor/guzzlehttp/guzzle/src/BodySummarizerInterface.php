<?php

namespace SMTP2GOWpPlugin\GuzzleHttp;

use SMTP2GOWpPlugin\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string;
}
