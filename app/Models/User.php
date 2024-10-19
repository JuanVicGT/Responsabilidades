<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Utils\Enums\StatusPasswordResetRequestEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'address',
        'birthdate',
        'last_name',
        'work_row',
        'work_position',
        'dependency',
        'admin',
        'status',
        'password',
        'avatar',
        'is_first_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'need_password_reset'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the password reset requests for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passwordResetRequests(): HasMany
    {
        return $this->hasMany(PasswordResetRequest::class);
    }

    /**
     * Get the pending password reset request for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pendingPasswordResetRequest(): HasOne
    {
        return $this->hasOne(PasswordResetRequest::class)
            ->where('status', StatusPasswordResetRequestEnum::NotVerified)->latestOfMany();
    }

    /**
     * Refuse the pending password reset request and set the need_password_reset column to false.
     * @return void
     */
    public function refusePasswordResetRequest(): bool
    {
        $passwordResetRequest = $this->pendingPasswordResetRequest;
        if ($passwordResetRequest->status === StatusPasswordResetRequestEnum::NotVerified->value) {
            $this->need_password_reset = false;
            $hasUpdated = $this->save();

            if ($hasUpdated) {
                $passwordResetRequest->update(['status' => StatusPasswordResetRequestEnum::Refused->value]);
                return true;
            }
        }

        return false;
    }

    /**
     * Apply the password reset request and set the need_password_reset column to false.
     * @return bool
     */
    public function applyPasswordResetRequest(string $new_password): bool
    {
        $passwordResetRequest = $this->pendingPasswordResetRequest;
        if ($passwordResetRequest->status === StatusPasswordResetRequestEnum::NotVerified->value) {
            $this->password = Hash::make($new_password);
            $this->need_password_reset = false;
            $hasUpdated = $this->save();

            if ($hasUpdated) {
                $passwordResetRequest->update(['status' => StatusPasswordResetRequestEnum::Processed->value]);
                return true;
            }
        }

        return false;
    }
}
