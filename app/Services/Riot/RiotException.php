<?php

namespace App\Services\Riot;

use RuntimeException;

class RiotException extends RuntimeException
{
    public function __construct(public readonly int $status, string $message = '')
    {
        parent::__construct($message ?: "Riot API responded with HTTP {$status}");
    }

    public function isNotFound(): bool
    {
        return $this->status === 404;
    }

    /** A message that is safe to show to players (never mentions keys or internals). */
    public function userMessage(): string
    {
        return match (true) {
            $this->status === 404 => 'Riot could not find that account.',
            $this->status === 429 => 'Riot is busy right now, please try again in a minute.',
            default => 'The Riot API is not available right now, please try again later.',
        };
    }
}
