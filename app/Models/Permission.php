<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'group'];

    /**
     * Check if a specific role has this permission.
     */
    public function hasRole($role)
    {
        return \Illuminate\Support\Facades\DB::table('role_permissions')
            ->where('role', $role)
            ->where('permission_id', $this->id)
            ->exists();
    }
}
