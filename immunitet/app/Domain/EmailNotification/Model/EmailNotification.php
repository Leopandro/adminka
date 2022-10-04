<?php
namespace App\Domain\EmailNotification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property string list_item
 * @property string period
 */
class EmailNotification extends Model
{
    protected $table = 'email_notification';

    protected $fillable = [];
}
