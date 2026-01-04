<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $validRoles = ['admin', 'procurement', 'finance', 'kepala_gudang', 'staff_gudang', 'produksi'];

    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        $roles = $this->validRoles;
        
        $assignments = DB::table('role_permissions')->whereIn('role', $roles)->get();

        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role] = $assignments->where('role', $role)->pluck('permission_id')->toArray();
        }

        return view('settings.roles.index', compact('permissions', 'roles', 'rolePermissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'array'
        ]);

        $input = $request->input('permissions', []);
        $validPermissionIds = Permission::pluck('id')->toArray();

        try {
            DB::beginTransaction();
            
            // Only touch roles we are managing
            DB::table('role_permissions')->whereIn('role', $this->validRoles)->delete();
            
            $inserts = [];
            $affectedRoles = [];

            foreach ($input as $role => $permIds) {
                if (!in_array($role, $this->validRoles)) continue;
                
                $rolePerms = array_keys($permIds);
                foreach ($rolePerms as $permId) {
                    if (!in_array($permId, $validPermissionIds)) continue;
                    
                    $inserts[] = [
                        'role' => $role,
                        'permission_id' => $permId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                if (!empty($rolePerms)) {
                    $affectedRoles[] = ucfirst($role);
                }
            }
            
            if (!empty($inserts)) {
                collect($inserts)->chunk(500)->each(function($chunk) {
                    DB::table('role_permissions')->insert($chunk->toArray());
                });
            }
            
            $rolesLog = !empty($affectedRoles) ? implode(', ', array_unique($affectedRoles)) : 'Pembersihan Hak Akses';
            \App\Models\ActivityLog::log("Update Hak Akses", "Memperbarui konfigurasi hak akses untuk: " . $rolesLog);

            DB::commit();
            return back()->with('success', 'Konfigurasi hak akses berhasil diperbarui dan segera diaktifkan.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
        }
    }
}
