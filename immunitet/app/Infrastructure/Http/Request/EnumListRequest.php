<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Enum\ClaimReasonDisplayFor;
use App\Enum\ClientEmployeeAccountType;
use App\Enum\DemoRequestType;
use App\Enum\DocumentTemplateType;
use App\Enum\EducationLevel;
use App\Enum\EmployeesCount;
use App\Enum\FeedbackType;
use App\Enum\FileStorageCode;
use App\Enum\Grade;
use App\Enum\Language;
use App\Enum\LanguageLevel;
use App\Enum\SocialLink;
use App\Enum\SpecialistRequestWorkPlace;
use App\Enum\VerificationLevel;
use App\Enum\WithoutVATArticle;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос на получение значений справочника (Enum в терминологии бэка)
 */
class EnumListRequest extends FormRequest
{
    public function rules(): array
    {
        $allowedEnums = [
            EmployeesCount::class,
            VerificationLevel::class,
            Language::class,
            LanguageLevel::class,
            EducationLevel::class,
            SpecialistRequestWorkPlace::class,
            DocumentTemplateType::class,
            FeedbackType::class,
            Grade::class,
            ClaimReasonDisplayFor::class,
            DemoRequestType::class,
            FileStorageCode::class,
            ClientEmployeeAccountType::class,
            SocialLink::class,
            WithoutVATArticle::class,
        ];

        $strEnumNames = collect($allowedEnums)->map(static function (string $className) {
            $classNameParts = explode('\\', $className);
            return end($classNameParts);
        })->join(',');

        return [
            'type' => 'required|in:' . $strEnumNames,
        ];
    }
}
