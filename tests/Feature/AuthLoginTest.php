<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;
    
    function test_user_can_view_a_login_form() {
        $this->get('/login')
            ->assertSuccessful()
            ->assertViewIs('auth.custom-login');
    }

    function test_user_can_view_a_reset_password_form() {
        $this->get('/password/reset')
            ->assertSuccessful()
            ->assertViewIs('auth.passwords.custom-email');
    }

    function test_user_cannot_view_a_login_from_when_authenticated() {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/');
    }

    function test_user_can_login_with_correct_credentials() {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secreto'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/panel');
        $this->assertAuthenticatedAs($user);
    }

    function test_user_cannot_login_with_incorrect_password() {
        $user = factory(User::class)->create([
            'password' => bcrypt('secreto'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    function test_remember_me_functionality() {
        $user = factory(User::class)->create([
            'id' => random_int(1,100),
            'password' => bcrypt($password = 'secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect('/panel');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }
}
