<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Seedpermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'jadwal.create']);
        Permission::create(['name' => 'jadwal.delete']);
        Permission::create(['name' => 'jadwal.update']);
        Permission::create(['name' => 'jadwal.view']);

    }
}
