<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AuthorType;
use App\Genre;
use App\Means;
use App\Model;
use App\Section;
use App\Sector;
use App\Source;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    $st_num = 1;
    $end_num = 8000;
    $mul = 1000000;
    $date = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now');
    return [
        'title' => $faker->sentence, 
        'synthesis' => $faker->text, 
        'author' => $faker->name, 
        'author_type_id' => AuthorType::all()->random()->id, 
        'sector_id' => Sector::all()->random()->id, 
        'genre_id' => Genre::all()->random()->id, 
        'source_id' => Source::all()->random()->id, 
        'section_id' => Section::all()->random()->id, 
        'mean_id' => Means::all()->random()->id, 
        'news_date' => $date, 
        'cost' => mt_rand($st_num*$mul,$end_num*$mul)/$mul, 
        'trend' => rand(1,3), 
        'scope' => rand(1,300), 
        'comments' => $faker->text, 
        'in_newsletter' => 0, 
        'metas_news' => 'a:2:{s:9:"news_hour";s:8:"10:30:00";s:13:"news_duration";s:8:"00:15:00";}', 
        'user_id' => User::all()->random()->id,
        'created_at' => $date
    ];
});
