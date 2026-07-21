<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // super_admin, admin, technician, salesman
        'phone',
        'skill_level',
        'experience',
        'branch',
        'avatar',
        'permissions',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'permissions' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get repairs assigned to this user (technician).
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class, 'assigned_technician_id');
    }

    /**
     * Helper checks for roles.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTechnician(): bool
    {
        return $this->role === 'technician';
    }

    public function isSalesman(): bool
    {
        return $this->role === 'salesman';
    }

    /**
     * Check if user has permission to access a feature.
     */
    public function hasPermissionTo(string $feature): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->permissions && is_array($this->permissions)) {
            return !empty($this->permissions[$feature]);
        }

        $defaults = [
            'admin' => ['pos' => true, 'repairs' => true, 'inventory' => true, 'purchases' => true, 'expenses' => true, 'reports' => true, 'social_media' => true],
            'technician' => ['repairs' => true],
            'salesman' => ['pos' => true, 'inventory' => true],
        ];

        return !empty($defaults[$this->role][$feature]);
    }
}
