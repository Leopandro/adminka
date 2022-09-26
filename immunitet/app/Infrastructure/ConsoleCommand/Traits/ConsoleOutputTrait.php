<?php

declare(strict_types=1);

namespace App\Infrastructure\ConsoleCommand\Traits;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

trait ConsoleOutputTrait
{
    private ProgressBar $bar;

    protected function progressBar(int $elementsCount, string $title = ''): ?ProgressBar
    {
        /** @var Command|ConsoleOutputTrait $this */

        if ($this->isVerbose()) {
            $this->bar = $this->output->createProgressBar($elementsCount);

            if ($title !== '') {
                $this->bar->setMessage($title);
            }

            return $this->bar;
        }

        return null;
    }

    protected function progressBarAdvance(int $step = 1): void
    {
        /** @var Command|ConsoleOutputTrait $this */

        if ($this->isVerbose()) {
            $this->bar->advance($step);
        }
    }

    protected function writeln(string $message): void
    {
        /** @var Command|ConsoleOutputTrait $this */

        if ($this->isVerbose()) {
            $this->getOutput()->writeln($message);
        }
    }

    protected function progressBarFinish(): void
    {
        /** @var Command|ConsoleOutputTrait $this */

        if ($this->isVerbose()) {
            $this->bar->finish();
            $this->output->newLine();
        }
    }

    protected function writelnEx(string $message): void
    {
        /** @var Command|ConsoleOutputTrait $this */

        if ($this->isVerbose()) {
            $this->getOutput()->writeln($message);
        }
    }

    protected function isVerbose(): bool
    {
        /** @var Command|ConsoleOutputTrait $this */

        return !$this->option('quiet');
    }
}
