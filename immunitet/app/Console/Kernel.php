<?php

namespace App\Console;

use App\Domain\Payment\Console\PaymentStatusFetchCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        PaymentStatusFetchCommand::class
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $scheduleCommand = static function (string $command, array $params = []) use ($schedule): \Illuminate\Console\Scheduling\Event {
            return $schedule
                ->command($command, array_merge($params, ['-q']))
                ->timezone('Europe/Moscow');
        };
        $scheduleCommand(PaymentStatusFetchCommand::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
