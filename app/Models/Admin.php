<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password', 'role', 'client_id', 'email_verified_at', 'last_login_at'];
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
}
