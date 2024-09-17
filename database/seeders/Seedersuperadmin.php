<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class Seedersuperadmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed role superadmin
        $superAdminRole = Role::create(['name' => 'SuperAdmin']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole($superAdminRole);
        }
        
    }
}
