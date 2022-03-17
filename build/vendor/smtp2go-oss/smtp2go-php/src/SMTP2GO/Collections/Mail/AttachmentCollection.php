<?php

namespace SMTP2GOWPPlugin\SMTP2GO\Collections\Mail;

use SMTP2GOWPPlugin\SMTP2GO\Types\Mail\Attachment;
use SMTP2GOWPPlugin\SMTP2GO\Collections\Collection;
class AttachmentCollection extends Collection
{
    protected $items;
    public function __construct(array $attachments = [])
    {
        foreach ($attachments as $attachment) {
            $this->add($attachment);
        }
    }
    public function add($attachment)
    {
        if (\is_a($attachment, Attachment::class)) {
            $this->items[] = $attachment;
        } else {
            throw new \InvalidArgumentException('This collection expects objects of type ' . Attachment::class, ' but recieved ' . \get_class($attachment));
        }
        return $this;
    }
}
