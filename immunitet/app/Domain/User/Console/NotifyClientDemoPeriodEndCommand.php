<?php

declare(strict_types=1);

namespace App\Domain\User\Console;

use App\Domain\User\Model\User;
use App\Infrastructure\ConsoleCommand\BaseConsoleCommand;
use App\Notifications\DemoPeriod\DemoPeriodEndClientNotification;

/**
 * Команда для отправки пользователям напоминаний об окончании демо-периода
 */
class NotifyClientDemoPeriodEndCommand extends BaseConsoleCommand
{
    protected $signature = 'demo-period:notify-client-about-period-end';

    protected $description = 'Напоминание пользователям об окончании демо-периода';

    public function handleInternal()
    {
        $verbose = !$this->option('quiet');

        $endDate = now()->format('Y-m-d');

        $users = User::query()
            ->whereHas('clientEmployee')
            ->whereDate('demo_period_end', $endDate)
            ->get();

        if (!$users->count()) {
            return;
        }

        if ($verbose) {
            $bar = $this->output->createProgressBar($users->count());
            $bar->setMessage('Отправка уведомлений');
        }

        /** @var User $user */
        foreach ($users as $user) {
            $user->notify(new DemoPeriodEndClientNotification());

            if ($verbose) {
                $bar->advance();
            }
        }

        if ($verbose) {
            $bar->finish();
            $this->line('');
        }
    }
}
