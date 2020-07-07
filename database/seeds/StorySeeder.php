<?php

use App\Models\Genre;
use App\Models\Licence;
use App\Models\Story;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 44; $i++) {

            $story = Story::create([
                'title' => $faker->realText($maxNbChars = rand(20, 50), $indexSize = 1),
                'description' => $faker->realText($maxNbChars = rand(100, 300), $indexSize = 1),
                'language' => $faker->randomElement(['ID', 'EN']),
                'price' => rand(10000, 99999),
                'status' => 'PUBLISH',
                'genre_id' => $faker->randomElement(Genre::all()->pluck('id')->toArray()),
                'cover' => 'story/cover/default.png',
                'licence_id' => $faker->randomElement(Licence::all()->pluck('id')->toArray()),
                'user_id' => rand(107, 156)
            ]);
            for ($j = 0; $j < rand(20, 50); $j++) {
                $story->parts()->create([
                    'part_cover' => 'story/part/cover/default.png',
                    'part_title' => 'Chapter' . ($j + 1) . ' - ' . $faker->realText($maxNbChars = rand(20, 50), $indexSize = 1),
                    'part_description' => $faker->realText($maxNbChars = rand(500, 1500), $indexSize = 1),
                ]);
            }
        }
    }
}
