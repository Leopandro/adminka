<?php
namespace App\Domain\SiteVerification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property string list_item
 * @property string period
 */
class SiteVerification extends Model
{
    protected $table = 'site_verification';

    protected $fillable = [];
}
