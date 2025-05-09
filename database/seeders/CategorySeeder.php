<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [
            'Web Development',
            'Mobile App Development',
            'UI/UX Design',
            'Machine Learning',
            'Cyber Security',
            'Game Development',
            'Digital Marketing',
            'DevOps',
            'Data Science',
            'Artificial Intelligence',
            'Cloud Computing',
            'Blockchain Development',
            'Software Testing',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name'        => $name,
                'description' => $faker->sentence,
                'poster'      => $faker->imageUrl(640, 480, 'business', true),
                'preview'     => $faker->imageUrl(640, 480, 'technology', true),
            ]);
        }
    }
}
