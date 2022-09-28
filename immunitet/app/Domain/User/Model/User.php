<?php

namespace App\Domain\User\Model;

use App\Domain\Company\Model\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string login
 * @property string name
 * @property string password
 * @property string middle_name
 * @property string surname
 * @property string email
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public static function createUser(
        string $id,
        string $email,
        string $plainPassword,
        string $name,
        ?string $surName = null,
        ?string $middleName = null
    ): User {
        $user = new static();

        $user->id = $id;
        $user->email = Str::lower($email);
        $user->password = Hash::make($plainPassword);
        $user->name = $name;
        $user->surname = $surName;
        $user->middle_name = $middleName;

        $user->save();

        return $user;
    }
}
