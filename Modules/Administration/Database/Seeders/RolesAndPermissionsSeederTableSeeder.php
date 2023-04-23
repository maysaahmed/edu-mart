<?php

namespace Modules\Administration\Database\Seeders;

use App\Enums\EnumUserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Administration\Domain\Entities\Admin\Admin;
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
            'password' => bcrypt('admin'),
            'type'     => EnumUserTypes::Admin
        ]);

        // Create permissions from enums.
        $reflector = new \ReflectionClass('App\Enums\PermissionsEnum');

        foreach ( $reflector->getConstants() as $constValue ) {
            Permission::updateOrCreate(['name' => $constValue]);
        }

//        // or may be done by chaining
        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
//
        $user->assignRole('super-admin');



    }
}
