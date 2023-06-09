<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\EnumUserTypes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Domain\Entities\User\User::Create([
            'name' => 'org2-manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('manager'),
            'type'     => EnumUserTypes::Manager,
            'organization_id' => 2
        ]);

        \App\Domain\Entities\User\User::Create([
            'name' => 'org2-user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'type'     => EnumUserTypes::User,
            'organization_id' => 2,
            'created_by' => 6
        ]);
    }
}
