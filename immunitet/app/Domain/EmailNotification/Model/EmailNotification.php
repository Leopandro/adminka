<?php
namespace App\Domain\EmailNotification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property string email_list
 * @property string period
 */
class EmailNotification extends Model
{
    protected $table = 'email_notification';

    protected $fillable = [];

    protected $casts = [
        'email_list' => 'array',
    ];
}
