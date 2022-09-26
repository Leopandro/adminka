<?php
namespace App\Domain\Country\Model;

use App\Domain\Company\Model\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string name
 */
class Country extends Model
{
    protected $table = 'country';

    protected $fillable = [];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
