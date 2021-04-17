<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AssignedNews;
use App\Company;
use App\News;
use Faker\Generator as Faker;

$factory->define(AssignedNews::class, function (Faker $faker) {
    $company = Company::all()->random();
    $theme = $company->themes->random();
    $note = News::all()->random();
    return [
        'news_id' => $note->id, 
        'company_id' => $company->id, 
        'theme_id' => $theme->id,
        'created_at' => $note->created_at
    ];
});
