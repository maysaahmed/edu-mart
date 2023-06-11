<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $levels = [
            ['name' => 'Basic', '#7A67C5'],
            ['name' => 'Advanced', '#0071C1'],
            ['name' => 'Senior', '#FBD34D'],
        ];
        DB::table('levels')->insert($levels);

    }
}
