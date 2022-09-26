<?php
namespace App\Domain\Company\Model;

use App\Domain\Company\Model\QueryBuilder\CompanyQueryBuilder;
use App\Domain\Country\Model\Country;
use App\Domain\User\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string name
 * @property integer inn
 * @property integer postcode
 * @property integer country_id
 * @property User user
 * @property string city
 * @property Country country
 */
class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name',
        'inn',
        'city',
        'postcode',
        'country_id',
        'address',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function newEloquentBuilder($query): CompanyQueryBuilder
    {
        return new CompanyQueryBuilder($query);
    }

    public static function query(): CompanyQueryBuilder
    {
        return parent::query();
    }
}
