<?php

declare(strict_types=1);

namespace MsgOwl\MsgowlLaravelNotificationChannel;

class MsgOwlMessage
{
    public string $body;

    public array|string|int $recipients;

    public string $sender_id;

    public function __construct(string $body = '')
    {
        if (! empty($body)) {
            $this->body = trim($body);
        }
    }

    public static function create(string $body = ''): self
    {
        return new static($body);
    }

    public function setBody(string $body): self
    {
        $this->body = trim($body);

        return $this;
    }

    public function setSenderId(string $sender_id): self
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    public function setRecipients(array|string|int $recipients): self
    {
        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        $this->recipients = $recipients;

        return $this;
    }

    public function toJson(): string
    {
        return json_encode($this);
    }
}
