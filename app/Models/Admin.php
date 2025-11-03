<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Admin extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use Notifiable, SoftDeletes, CanResetPasswordTrait;

    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'phone', 'password', 'role', 'client_id', 'email_verified_at', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClientHr()
    {
        return $this->role === 'client_hr';
    }

    public function getStatusAttribute()
    {
        return $this->email_verified_at ? 'active' : 'inactive';
    }

    public function getRoleNameAttribute()
    {
        return match($this->role) {
            'super' => 'Super Admin',
            'admin' => 'Admin',
            'client_hr' => 'Client HR',
            default => 'Unknown',
        };
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeInactive($query)
    {
        return $query->whereNull('email_verified_at');
    }

    public function scopeSuperAdmin($query)
    {
        return $query->where('role', 'super');
    }

    public function scopeClientHr($query)
    {
        return $query->where('role', 'client_hr');
    }

    /**
     * Determine if this admin should receive application email notifications.
     */
    public function wantsApplicationEmails(): bool
    {
        return $this->role === 'super';
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\AdminResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\AdminEmailVerification());
    }

    /**
     * Determine if the admin has verified their email address.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the given admin's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }
}
