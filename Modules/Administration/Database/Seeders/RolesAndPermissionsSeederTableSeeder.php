<?php

namespace Modules\Administration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //create default super admin
        $user = Admin::Create([
            'name' => 'super-admin',
            'email' => 'superAdmin@gmail.com',
            'password' => bcrypt('admin')
        ]);



        // create permissions
        Permission::create(['name' => 'create organization']);
        Permission::create(['name' => 'edit organizations']);
        Permission::create(['name' => 'delete organizations']);
        Permission::create(['name' => 'block organizations']);

        // or may be done by chaining
        $role = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        $user->assignRole('super-admin');
    }
}
