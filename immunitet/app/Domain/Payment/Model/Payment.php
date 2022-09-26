<?php
namespace App\Domain\Payment\Model;

use App\Domain\User\Model\User;
use App\Enum\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int sum
 * @property int user_id
 * @property int transaction_id
 * @property string payment_uuid
 * @property string payment_cryptogram
 * @property string currency
 * @property PaymentStatus status
 */
class Payment extends Model
{
    protected $fillable = [];

    protected $table = 'payment';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
