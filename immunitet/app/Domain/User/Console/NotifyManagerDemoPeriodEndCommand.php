<?php

declare(strict_types=1);

namespace App\Domain\User\Console;

use App\Domain\AccountManager\Model\AccountManager;
use App\Domain\Client\Model\Client;
use App\Infrastructure\ConsoleCommand\BaseConsoleCommand;
use App\Notifications\DemoPeriod\DemoPeriodEndManagerNotification;
use Illuminate\Database\Eloquent\Builder;

/**
 * Команда для отправки аккаунт-менеджерам клиентов напоминаний об окончании демо-периода у клиента
 */
class NotifyManagerDemoPeriodEndCommand extends BaseConsoleCommand
{
    protected $signature = 'demo-period:notify-manager-about-period-end';

    protected $description = 'Напоминание аккаунт-менеджерам клиентов об окончании демо-периода у клиента';

    public function handleInternal()
    {
        $verbose = !$this->option('quiet');

        $endDate = now()->format('Y-m-d');

        $clients = Client::query()
            ->whereHas(
                'employees',
                fn(Builder $q) => $q->whereHas(
                    'user',
                    fn(Builder $q) => $q->whereDate('demo_period_end', $endDate)
                )
            )
            ->with('managers')
            ->get();

        if (!$clients->count()) {
            return;
        }

        if ($verbose) {
            $bar = $this->output->createProgressBar($clients->count());
            $bar->setMessage('Отправка уведомлений');
        }

        /** @var Client $client */
        foreach ($clients as $client) {
            /** @var AccountManager $manager */
            foreach ($client->managers as $manager) {
                $manager->notify(new DemoPeriodEndManagerNotification($client));
            }

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
