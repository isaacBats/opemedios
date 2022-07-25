<?php

namespace Tests\Feature\Http\Controllers;

use App\{AssignedNews, Company, Means, News, Theme, User};
use MeansSeeder;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RolesTableSeeder;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_protected_routes()
    {
        $this->seed();
        $company = factory(Company::class)->create();
        $note = factory(News::class)->create();

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

    public function test_client_can_see_dashboard()
    {
        $this->seed(RolesTableSeeder::class);
        $client = factory(User::class)->create();
        $client->assignRole('client');
        $company = factory(Company::class)->create();
        $client->metas()->create([
            'meta_key' => 'company_id',
            'meta_value' => $company->id
        ]);

        $this->actingAs($client)
            ->get(route('news', ['company' => $company]))
            ->assertStatus(200)
            ->assertViewIs('clients.news')
            ->assertSee("Bienvenido a {$company->name}")
            ->assertSeeText(strtoupper(auth()->user()->name));
    }

    public function test_client_can_see_your_notes()
    {
        $this->withoutExceptionHandling();
        $this->seed();
        $client = factory(User::class)->create();
        $client->assignRole('client');
        $company = factory(Company::class)->create();
        $client->metas()->create([
            'meta_key' => 'company_id',
            'meta_value' => $company->id
        ]);
        $company->themes()->save(factory(Theme::class)->create());
        $news = factory(News::class, 15)->create();
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
}
