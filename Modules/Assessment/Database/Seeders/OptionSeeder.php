<?php

namespace Modules\Assessment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Assessment\Domain\Entities\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Option::updateOrCreate([
            'text' => [
                'en' => 'Disagree',
                'ar' => 'أختلف'
            ],
            'weight' => 1
        ]);

        Option::updateOrCreate([
            'text' => [
                'en' => 'Slightly Disagree',
                'ar' => 'أختلف قليلاً'
            ],
            'weight' => 2
        ]);

        Option::updateOrCreate([
            'text' => [
                'en' => 'Neutral',
                'ar' => 'محايد'
            ],
            'weight' => 3
        ]);

        Option::updateOrCreate([
            'text' => [
                'en' => 'Slightly agree',
                'ar' => 'أوافق قليلاً'
            ],
            'weight' => 4
        ]);

        Option::updateOrCreate([
            'text' => [
                'en' => 'Agree',
                'ar' => 'أوافق'
            ],
            'weight' => 5
        ]);

    }
}
