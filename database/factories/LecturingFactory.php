<?php

use App\Models\Lecturing;
use App\User;
use Faker\Generator as Faker;

$factory->define(Lecturing::class, function (Faker $faker) {
    return [
        'audience_code' => Lecturing::AUDIENCE_PUBLIC,
        'date' => today()->format('d-m-Y'),
        'start_time' => '06:00',
        'end_time' => null,
        'time_text' => 'Ba\'da Subuh',
        'lecturer_name' => 'Ustadz Haikal',
        'title' => $this->faker->words(3, true),
        'book_title' => 'Some Book Title',
        'book_writer' => 'A book writer',
        'book_link' => $this->faker->url,
        'video_link' => $this->faker->url,
        'audio_link' => $this->faker->url,
        'description' => $this->faker->sentence,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
