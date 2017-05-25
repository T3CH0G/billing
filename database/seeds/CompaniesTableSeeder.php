<?php

use Illuminate\Database\Seeder;
use App\Company;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CompaniesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create(); 
 
        foreach(range(1,30) as $index)
        {
            Company::create([                
                'name' => $faker->paragraph($nbSentences = 1),
                'user_id' =>$faker->numberBetween($min = 1, $max = 5)
            ]);
        }
    }
}
