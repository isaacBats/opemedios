<?php

namespace Database\Factories;

use App\{AuthorType, Genre, Means, Section, Sector, Source, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        $st_num = 1;
        $end_num = 8000;
        $mul = 1000000;
        $date = $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now');
        return [
            'title' => $this->faker->sentence,
            'synthesis' => $this->faker->text,
            'author' => $this->faker->name,
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
            'comments' => $this->faker->text,
            'in_newsletter' => 0,
            'metas_news' => 'a:2:{s:9:"news_hour";s:8:"10:30:00";s:13:"news_duration";s:8:"00:15:00";}',
            'user_id' => User::all()->random()->id,
            'created_at' => $date
        ];
    }
}
