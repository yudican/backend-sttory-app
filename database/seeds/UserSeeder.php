<?php

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
                'avatar' => 'users/avatar/ZBel38DniKPc5HEqPspcR0yEipgQ6yfvwtQWqdkV.png',
                'phone' => $faker->randomElement([12, 13, 57, 56, 58, 22, 17, 98, 53, 52]) . rand(1000, 9999) . rand(999, 9999),
                'description' => $faker->realText($maxNbChars = rand(50, 150), $indexSize = 1)
            ]);
            $user->genres()->attach([
                '109967d3-86a1-46eb-9046-97526b064002',
                '310f2fe3-19e0-4e55-b23e-fb152c6e1c28',
                '8b2d1ef8-a126-4cbc-bec8-319d400413f6'
            ]);
        }
    }
}
