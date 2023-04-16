<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\{Models\Company, Models\User, Models\UserMeta};
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_user_client_can_login_with_correct_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $user->metas()->saveMany([
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Agente de ventas'
            ]),
            new UserMeta([
                'meta_key'      => 'company_id',
                'meta_value'    => $company->id
            ])
        ]);

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('client');
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('client.mynews', ['company' => $company->slug]));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_client_can_login_with_correct_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $user->metas()->saveMany([
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Agente de ventas'
            ]),
            new UserMeta([
                'meta_key'      => 'company_id',
                'meta_value'    => $company->id
            ])
        ]);

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('client');
        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('client.mynews', ['company' => $company->slug]));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_client_can_not_login_with_incorrect_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $user->metas()->saveMany([
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Agente de ventas'
            ]),
            new UserMeta([
                'meta_key'      => 'company_id',
                'meta_value'    => $company->id
            ])
        ]);
        $user->assignRole('client');

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $response = $this->from('cuenta')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('cuenta')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }

    public function test_user_client_can_not_login_with_incorrect_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $user->metas()->saveMany([
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Agente de ventas'
            ]),
            new UserMeta([
                'meta_key'      => 'company_id',
                'meta_value'    => $company->id
            ])
        ]);

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('client');
        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('login')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }

    public function test_user_admin_can_login_with_correct_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->metas()->save(
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Gerente'
            ])
        );

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('admin');
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('panel'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_admin_can_login_with_correct_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->metas()->save(
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Gerente'
            ])
        );

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('admin');
        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('panel'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_admin_can_not_login_with_incorrect_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->metas()->save(
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Gerente'
            ])
        );

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('admin');
        $response = $this->from('cuenta')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('cuenta')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }

    public function test_user_admin_can_not_login_with_incorrect_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->metas()->save(
            new UserMeta([
                'meta_key'      => 'user_position',
                'meta_value'    => 'Gerente'
            ])
        );

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('admin');
        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('login')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }

    public function test_user_monitor_can_login_with_correct_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('monitor');
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('admin.news'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_monitor_can_login_with_correct_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('monitor');

        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'secret',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect(route('admin.news'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_monitor_can_not_login_with_incorrect_credentials()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('monitor');
        $response = $this->from('cuenta')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('cuenta')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }

    public function test_user_monitor_can_not_login_with_incorrect_credentials_from_login_view()
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();

        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $user->assignRole('monitor');
        $response = $this->from('login')->post('login', [
            'email' => $user->email,
            'password' => 'bad password',
            'g-recaptcha-response' => '1',
        ]);

        $response->assertRedirect('login')
            ->assertStatus(302)
            ->assertSessionHasErrors('email', 'password');
    }
}
