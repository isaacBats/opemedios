<?php

namespace Tests\Feature\Http\Controllers;

use App\{Models\AssignedNews, Models\Company, Models\News, Models\Theme, Models\User};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_protected_routes()
    {
        $this->seed();
        $company = Company::factory()->create();
        $note = News::factory()->create();

        $this->get(route('news', ['company', $company]))->assertRedirect('login');
        $this->get(route('client.sections', ['company', $company]))->assertRedirect('login');
        $this->get(route('client.shownew', ['company' => $company,'id' => $note->id]))->assertRedirect('login');
        $this->get(route('client.mynews', ['company', $company]))->assertRedirect('login');
        $this->get(route('client.report', ['company', $company]))->assertRedirect('login');

        $this->post(route('newsbytheme', ['company', $company]))->assertRedirect('login');
        $this->post(route('client.report', ['company', $company]))->assertRedirect('login');

        $this->get(route('api.client.notesday', ['company', $company]))->assertRedirect('login');
        $this->get(route('api.client.notesyear', ['company', $company]))->assertRedirect('login');
    }

    public function test_client_can_see_your_notes()
    {
        $this->withoutExceptionHandling();
        $this->seed();
        $client = User::factory()->create();
        $client->assignRole('client');
        $company = Company::factory()->create();
        $client->metas()->create([
            'meta_key' => 'company_id',
            'meta_value' => $company->id
        ]);
        $company->themes()->save(Theme::factory()->create());
        $news = News::factory(15)->create();
        foreach ($news as $note) {
            $assigned = new AssignedNews([
                'news_id' => $note->id,
                'theme_id' => $company->themes()->first()->id,
                'company_id' => $company->id
            ]);
            $assigned->save();
        }

        $this->actingAs($client)
            ->get(route('client.mynews', ['company' => $company]))
            ->assertStatus(200)
            ->assertViewIs('clients.mynews')
            ->assertSee($news->first()->title);
    }
    public function test_client_can_filter_their_notes()
    {
        $this->withoutExceptionHandling();
        $this->seed();
        $client = User::factory()->create();
        $client->assignRole('client');
        $company = Company::factory()->create();
        $client->metas()->create([
            'meta_key' => 'company_id',
            'meta_value' => $company->id
        ]);
        $company->themes()->saveMany([
            Theme::factory()->create(),
            Theme::factory()->create(),
            Theme::factory()->create(),
        ]);
        $news = News::factory(15)->create();

        foreach ($news as $note) {
            $assigned = new AssignedNews([
                'news_id' => $note->id,
                'theme_id' => $company->themes->random()->id,
                'company_id' => $company->id
            ]);
            $assigned->save();
        }
        $theme = Theme::find($company->themes->random()->id);
        $assignedCount = $company->assignedNews()->where('theme_id', $theme->id)->count();

        $this->actingAs($client)
            ->get(route('client.mynews', [
                'company' => $company,
                'theme' => $theme
            ]))
            ->assertStatus(200)
            ->assertViewIs('clients.mynews');
    }
}
