<?php
namespace App\Domain\SiteVerification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string value
 * @property int list_item
 */
class SiteVerificationItem extends Model
{
    protected $table = 'site_verification_list_item';

    protected $fillable = ['value','site_list_id'];
}
