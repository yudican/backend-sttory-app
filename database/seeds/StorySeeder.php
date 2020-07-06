<?php

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
                'genre_id' => $faker->randomElement(['109967d3-86a1-46eb-9046-97526b064002', '310f2fe3-19e0-4e55-b23e-fb152c6e1c28', '8b2d1ef8-a126-4cbc-bec8-319d400413f6']),
                'cover' => 'story/cover/g0V7l1SCUhjWYTPLpkbOAItXYbscck97Lqy6f8NY.png',
                'licence_id' => '439864fc-4bc0-4eae-9349-947124f8dc6b',
                'user_id' => rand(107, 156)
            ]);
            for ($j = 0; $j < rand(20, 50); $j++) {
                $story->parts()->create([
                    'part_cover' => 'story/part/cover/GosFmVuYPWSRlprmSqR7CHENJZtUZBXDfMGGfzT9.png',
                    'part_title' => 'Chapter' . ($j + 1) . ' - ' . $faker->realText($maxNbChars = rand(20, 50), $indexSize = 1),
                    'part_description' => $faker->realText($maxNbChars = rand(500, 1500), $indexSize = 1),
                ]);
            }
        }
    }
}
