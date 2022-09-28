<?php
namespace App\Domain\SiteVerification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property string verification_list
 * @property string period
 */
class SiteVerification extends Model
{
    protected $table = 'site_verification';

    protected $fillable = [];

    protected $casts = [
        'verification_list' => 'array',
    ];
}
