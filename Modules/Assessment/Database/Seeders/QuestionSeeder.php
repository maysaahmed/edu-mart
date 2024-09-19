<?php

namespace Modules\Assessment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('questions')->insert([
            [
                'ques' => 'Product 3',
                'order' => 1,
                'factor_id' => 199.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
