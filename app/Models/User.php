<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // ▼ TAMBAHKAN BARIS INI ▼
    use HasFactory, Notifiable; 

    /** @use HasFactory<\Database\Factories\UserFactory> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'phone',
        'status',
    ];

    protected $attributes = [
        'role' => 'staff_gudang',
        'status' => 'active',
    ];

    /**
     * Cache for user permissions to avoid repeated DB queries during a single request.
     */
    protected $permissions_cache = null;

    /**
     * Check if user has a specific permission based on their role.
     */
    public function hasPermission($permissionName)
    {
        if ($this->role === 'admin') return true;

        if ($this->permissions_cache === null) {
            $this->permissions_cache = \Illuminate\Support\Facades\DB::table('role_permissions')
                ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                ->where('role_permissions.role', $this->role)
                ->pluck('permissions.name')
                ->toArray();
        }

        return in_array($permissionName, $this->permissions_cache);
    }

    /**
     * Check if user has ANY of the given permissions.
     */
    public function hasAnyPermission(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }


    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}