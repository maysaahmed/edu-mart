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
            ['name' => 'Basic'],
            ['name' => 'Advanced'],
            ['name' => 'Senior'],
        ];
        DB::table('levels')->insert($levels);

    }
}
