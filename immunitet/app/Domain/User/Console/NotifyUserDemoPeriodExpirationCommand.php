<?php

declare(strict_types=1);

namespace App\Domain\User\Console;

use App\Domain\User\Model\User;
use App\Infrastructure\ConsoleCommand\BaseConsoleCommand;
use App\Notifications\DemoPeriod\DemoPeriodExpiresInDaysNotification;

/**
 * Команда для отправки пользователям напоминаний
 * об окончании демо-периода через определенное кол-во дней
 */
class NotifyUserDemoPeriodExpirationCommand extends BaseConsoleCommand
{
    protected $signature = 'demo-period:notify-about-period-expiration {--days=0}';

    protected $description = 'Напоминание пользователям об истечении срока демо-периода';

    public function handleInternal()
    {
        $verbose = !$this->option('quiet');

        $days = (int)$this->option('days');

        if (!$days) {
            throw new \RuntimeException('Не указано количество дней');
        }

        $endDate = now()->addDays($days)->format('Y-m-d');

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
            $user->notify(new DemoPeriodExpiresInDaysNotification($days));

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
