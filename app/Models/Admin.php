<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password', 'is_super', 'email_verified_at', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_super' => 'boolean',
    ];

    public function isSuperAdmin()
    {
        return $this->is_super === true;
    }

    public function getStatusAttribute()
    {
        return $this->email_verified_at ? 'active' : 'inactive';
    }

    public function getRoleAttribute()
    {
        return $this->is_super ? 'super_admin' : 'admin';
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
        return $query->where('is_super', true);
    }
}
