<?php

use App\Models\Genre;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                'fullname' => $faker->name,
                'username' => explode(' ', $faker->name)[0] . rand(1000, 9999),
                'email' => $faker->unique()->email,
                'password' => Hash::make('user1234')
            ]);
            $user->profile()->create([
                'avatar' => 'users/avatar/default.png',
                'phone' => $faker->randomElement([12, 13, 57, 56, 58, 22, 17, 98, 53, 52]) . rand(1000, 9999) . rand(999, 9999),
                'description' => $faker->realText($maxNbChars = rand(50, 150), $indexSize = 1)
            ]);
            $user->genres()->attach(Genre::limit(3)->get(['id'])->pluck('id')->toArray());
        }
    }
}
