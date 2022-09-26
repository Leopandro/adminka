<?php

declare(strict_types=1);

namespace App\Infrastructure\ConsoleCommand;

/**
 * Логгер для консольных комманд.
 */
class ConsoleCommandLogger
{
    public function error(BaseConsoleCommand $command, string $message): void
    {
        \Log::error($message, [
            'command' => $command->getSignature(),
        ]);
    }

    public function info(BaseConsoleCommand $command, string $message): void
    {
        \Log::info($message, [
            'command' => $command->getSignature(),
        ]);
    }
}
