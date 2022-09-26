<?php

declare(strict_types=1);

namespace App\Domain\User\Console;

use App\Domain\SpecialistsRequestList\Model\SpecialistsRequestList;
use App\Domain\User\Model\User;
use App\Infrastructure\ConsoleCommand\BaseConsoleCommand;
use Carbon\Carbon;

/**
 * Команда для удаления аккаунтов, которые не были подтверждены через email
 * Удаляются аккаунты, старше определенного периода, задаваемого в конфиге params.deleteOldUnverifiedUsersAfterMonths
 */
class DeleteOldUnverifiedUsersCommand extends BaseConsoleCommand
{
    protected $signature = 'users:delete-old-unverified';

    protected $description = 'Удаление неподтвержденных через email аккаунтов';

    /**
     * @throws \Throwable
     */
    public function handleInternal(): void
    {
        $users = User::query()->where(['email_verified_at' => null])
            ->with('specialistRequestLists', 'specialistRequestLists.items')
            ->where(
                'created_at',
                '<=',
                Carbon::now()->subMonths(config('params.deleteOldUnverifiedUsersAfterMonths'))
            )->get();

        if (!$this->option('quiet')) {
            $bar = $this->output->createProgressBar(count($users));
        }

        foreach ($users as $user) {
            \DB::beginTransaction();

            try {
                $user->specialistRequestLists->each(static function (SpecialistsRequestList $list) {
                    $list->items()->delete();
                });

                $user->specialistRequestLists()->delete();
                $user->delete();

                \DB::commit();
            } catch (\Throwable $ex) {
                \DB::rollBack();
                throw $ex;
            }

            if (!$this->option('quiet')) {
                $bar->advance();
            }
        }

        if (!$this->option('quiet')) {
            $bar->finish();
            $this->line('');
        }
    }
}
