<?php

namespace Database\Seeders\Skijasi\Content;

use Illuminate\Database\Seeder;
use NadzorServera\Skijasi\Models\Permission;
use NadzorServera\Skijasi\Models\Role;
use NadzorServera\Skijasi\Models\RolePermission;

class SkijasiContentRolePermissionsSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $administrator = Role::where('name', 'administrator')->firstOrFail();

            $permissions = Permission::all();

            if (! is_null($administrator)) {
                foreach ($permissions as $row) {
                    $role_permission = RolePermission::where('role_id', $administrator->id)
                            ->where('permission_id', $row->id)
                            ->first();
                    if (is_null($role_permission)) {
                        $role_permission = new RolePermission();
                        $role_permission->role_id = $administrator->id;
                        $role_permission->permission_id = $row->id;
                        $role_permission->save();
                    }
                }
            }

            \DB::commit();
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }
    }
}
