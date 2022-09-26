<?php

declare(strict_types=1);

namespace App\Infrastructure\ConsoleCommand;

use App\Infrastructure\ConsoleCommand\Traits\ConsoleOutputTrait;
use Illuminate\Console\Command;

/**
 * Базовый класс для консольных комманд
 */
abstract class BaseConsoleCommand extends Command
{
    use ConsoleOutputTrait;

    protected $signature = null;

    protected $description = null;

    abstract public function handleInternal();

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function isLoggable(): bool
    {
        return false;
    }

    public function handle(ConsoleCommandLogger $logger): void
    {
        if ($this->isLoggable()) {
            $logger->info($this, sprintf('Команда "%s" запущена', $this->signature));
        }

        $this->handleInternal();

        if ($this->isLoggable()) {
            $logger->info($this, sprintf('Команда "%s" выполнена', $this->signature));
        }
    }
}
