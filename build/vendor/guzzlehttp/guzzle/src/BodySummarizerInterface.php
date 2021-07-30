<?php

namespace SMTP2GOWPPlugin\GuzzleHttp;

use SMTP2GOWPPlugin\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string;
}
