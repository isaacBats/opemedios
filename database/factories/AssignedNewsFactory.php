<?php

namespace Database\Factories;

use App\{Models\Company, Models\News};
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignedNewsFactory extends Factory
{
    public function definition(): array
    {
        $company = Company::all()->random();
        $theme = $company->themes->random();
        $note = News::all()->random();
        return [
            'news_id' => $note->id,
            'company_id' => $company->id,
            'theme_id' => $theme->id,
            'created_at' => $note->created_at
        ];
    }
}
