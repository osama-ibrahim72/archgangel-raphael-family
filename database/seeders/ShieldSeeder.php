<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_church","view_any_church","create_church","update_church","restore_church","restore_any_church","replicate_church","reorder_church","delete_church","delete_any_church","force_delete_church","force_delete_any_church","view_father","view_any_father","create_father","update_father","restore_father","restore_any_father","replicate_father","reorder_father","delete_father","delete_any_father","force_delete_father","force_delete_any_father","view_meeting","view_any_meeting","create_meeting","update_meeting","restore_meeting","restore_any_meeting","replicate_meeting","reorder_meeting","delete_meeting","delete_any_meeting","force_delete_meeting","force_delete_any_meeting","view_service","view_any_service","create_service","update_service","restore_service","restore_any_service","replicate_service","reorder_service","delete_service","delete_any_service","force_delete_service","force_delete_any_service","view_student","view_any_student","create_student","update_student","restore_student","restore_any_student","replicate_student","reorder_student","delete_student","delete_any_student","force_delete_student","force_delete_any_student","view_teacher","view_any_teacher","create_teacher","update_teacher","restore_teacher","restore_any_teacher","replicate_teacher","reorder_teacher","delete_teacher","delete_any_teacher","force_delete_teacher","force_delete_any_teacher","widget_StatsOverview","widget_MostAttendChart","widget_MostMeetingChart","widget_InsideChart"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
