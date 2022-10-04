<?php
namespace App\Domain\EmailNotification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int email_list_id
 * @property string value
 */
class EmailNotificationItem extends Model
{
    protected $table = 'email_notification_list_item';

    protected $fillable = ['value', 'email_list_id'];
}
