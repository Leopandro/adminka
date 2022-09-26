<?php

namespace App\Domain\User\UseCase\Create;

use App\Domain\Phone\Model\Phone;
use App\Domain\User\Exception\UserWithEmailExistsException;
use App\Domain\User\Model\User;
use App\Enum\PhoneType;
use App\Enum\UserStatus;
use App\Infrastructure\Command\Handler\BaseCommandHandler;
use App\Infrastructure\Entity\SocialNetwork;
use App\Infrastructure\File\Entity\FileData;
use App\Infrastructure\File\Service\FileSaver;
use App\Infrastructure\Media\Model\Media;
use App\Infrastructure\Model\Permissions\Role;
use App\Infrastructure\Storage\Service\StorageManager;
use BenSampo\Enum\Exceptions\InvalidEnumMemberException;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use libphonenumber\NumberParseException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data;
use Throwable;

class UserCreateCommandHandler extends BaseCommandHandler
{
    private UserCreateCommand $command;

    public function __construct(UserCreateCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserCreateCommand
    {
        return $this->command;
    }

    /**
     * @throws UserWithEmailExistsException
     * @throws InvalidEnumMemberException
     * @throws ValidationException
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws InvalidBase64Data
     * @throws Throwable
     * @throws NumberParseException
     */
    public function handle(): void
    {
        $command = $this->command;

        if (User::query()->whereEmail($command->email)->first('id')) {
            throw new UserWithEmailExistsException();
        }

        if (isset($command->roles)) {
            $roles = Role::query()
                ->whereIn('id', $command->roles)
                ->get();
        }

        DB::beginTransaction();

        try {
            $user = new User();

            $user->id = $command->id;
            $user->email = Str::lower($command->email);
            $user->password = Hash::make($command->password);
            $user->name = $command->name;
            $user->surname = $command->surname;
            $user->middlename = $command->middlename ?? null;
            $user->status = new UserStatus($command->status);

            if (isset($command->demo_period_end)) {
                $user->demo_period_end = $command->demo_period_end;
            }

            if (isset($command->email_verified_at)) {
                $user->email_verified_at = $command->email_verified_at;
            }

            if (isset($command->b24_id)) {
                $user->b24_id = $command->b24_id;
            }

            if (isset($command->socialNetworks)) {
                $socialNetworks = [];

                foreach ($command->socialNetworks as $socialNetwork) {
                    $socialNetworks[] = SocialNetwork::fromArray($socialNetwork);
                }

                $user->social_networks = $socialNetworks;
            }

            $user->save();

            if (isset($roles)) {
                $user->assignRole($roles);
            }

            if (isset($command->mobilePhone)) {
                $user->phones()->save(Phone::initPhone($command->mobilePhone, PhoneType::MOBILE));
            }

            if (isset($command->workPhone)) {
                $user->phones()->save(Phone::initPhone($command->workPhone, PhoneType::WORK));
            }

            if (isset($command->avatar)) {
                $diskName = app(StorageManager::class)->getDiskCodeForCountry('RU');

                $fileData = FileData::fromFields($command->avatar);

                app(FileSaver::class)->save($fileData, $user, Media::COLLECTION_USER_AVATAR, $diskName);
            }

            DB::commit();
        } catch (Throwable $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}
