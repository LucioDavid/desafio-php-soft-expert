<?php

namespace Src\Core;

use Src\Core\Enums\SessionMessageTypes;

class Session
{
    public static function start(): void
    {
        session_start();
    }

    public static function setMessage(string $message, SessionMessageTypes $type): void
    {
        $_SESSION['messages'][] = [
            'content' => $message,
            'type' => $type->value
        ];
    }

    public static function getMessages(): array
    {
        $messages = $_SESSION['messages'] ?? [];
        unset($_SESSION['messages']);
        return $messages;
    }
}
