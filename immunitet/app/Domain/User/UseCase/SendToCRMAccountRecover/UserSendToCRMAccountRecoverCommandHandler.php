<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SendToCRMAccountRecover;

use App\Domain\Agency\Model\Agency;
use App\Domain\Client\Model\Client;
use App\Enum\CompanyIdentifierType;
use App\Infrastructure\Command\CommandLogger;
use App\Infrastructure\Command\Handler\BaseCommandHandler;
use App\Infrastructure\CRM\Bitrix24\Bitrix24CrmClient;
use App\Infrastructure\CRM\Bitrix24\Entity\AccountRecover;
use App\Infrastructure\CRM\Bitrix24\Entity\Task\Task;
use App\Infrastructure\CRM\Bitrix24\FieldsMap\DealFieldsMap;
use App\Infrastructure\CRM\Bitrix24\FieldsMap\TaskFieldsMap;
use App\Infrastructure\Exception\Service\ExceptionFormatter;
use App\Infrastructure\Facade\TelegramNotifier;
use App\Infrastructure\Lang\Translator;
use App\Notifications\Telegram\TelegramErrorNotification;

class UserSendToCRMAccountRecoverCommandHandler extends BaseCommandHandler
{
    private UserSendToCRMAccountRecoverCommand $command;

    public function __construct(UserSendToCRMAccountRecoverCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserSendToCRMAccountRecoverCommand
    {
        return $this->command;
    }

    /**
     * @param Bitrix24CrmClient $crmClient
     * @throws \App\Infrastructure\Network\Exception\RequestException
     * @throws \Throwable
     */
    public function handle(Bitrix24CrmClient $crmClient): void
    {
        $command = $this->command;

        try {
            /** @var Agency|Client $company */
            $company = Agency::query()->find($command->companyUuid)
                ?? Client::query()->find($command->companyUuid);

            $dealFieldsMap = app(DealFieldsMap::class);
            $taskFieldsMap = app(TaskFieldsMap::class);

            $task = new Task();

            $manager = $company->managers()->first();
            $task->responsibleId = $manager ?
                (int)$manager->b24_id
                : (int)$dealFieldsMap->responsibleIdValue;

            $task->title = 'Восстановление доступов к аккаунту';
            $task->groupId = $taskFieldsMap->groupHelp;

            $task->crmEntities = [
                'CO_' . $company->b24_id,
            ];

            if (isset($command->contractNumber)) {
                $description = sprintf('Номер договора: %s', $command->contractNumber);
            } else {
                $title = Translator::translateEnumValue(new CompanyIdentifierType($command->documentTitle));
                $description = sprintf('%s: %s', $title, $command->documentValue);
            }

            $task->description = <<<DESCRIPTION
id компании: {$company->b24_id}
id компании на платформе: {$company->id}
Имя: {$command->fullName}
email: {$command->email}
Причина: {$command->reasons}
{$description}
DESCRIPTION;

            $taskData = $crmClient->createTask($task);

            app(CommandLogger::class)->logInfo($this->command, 'Создана задача в CRM для восстановления доступа к аккаунту', [
                'crmTaskId' => $taskData['id'],
            ]);
        } catch (\Throwable $ex) {
            $exceptionText = app(ExceptionFormatter::class)->formatForTelegram($ex);

            $message = <<<MSG
Ошибка отправки в Bitrix24 информации о запросе на восстановление доступа\n
\n
{$exceptionText}\n
MSG;
            app(CommandLogger::class)->logError($command, $message);

            TelegramNotifier::toErrorChannel(new TelegramErrorNotification($message));

            throw $ex;
        }
    }
}
