<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */

use Ramsey\Uuid\Uuid;

$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Genre::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'image' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Licence::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'descriptions' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
