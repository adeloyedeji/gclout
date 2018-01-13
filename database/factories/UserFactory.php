<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'username' => str_replace(" ", ".", $faker->firstName),
        'email' => $faker->unique()->freeEmail,
        'gender' => 0,
        'avatar' => 'public/defaults/avatars/female.jpg',
        'cover' =>  'public/covers/default.jpg',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id'   =>  factory(App\User::class)->create()->id,
        'state_id'  =>  rand(1, 36),
        'job'       =>  $faker->jobTitle,
        'address'   =>  $faker->streetAddress,
        'about'     =>  $faker->realText(500),
        'date_of_birth' =>  '1996-06-15',
        'country_id'    =>  149
    ];
});
