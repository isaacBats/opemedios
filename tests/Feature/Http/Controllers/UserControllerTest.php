<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that users are listed correctly.
     * @return void
     */
    public function test_users_index_displays_users()
    {
        $this->seed();
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('view menu');
        $adminUser = User::factory()->create();
        $adminUser->assignRole($role);
        $adminUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'admin'
        ]);

        $users = User::factory(30)->create();
        $clientRole = Role::where('name', 'client')->first();
        foreach ($users as $user){
            $user->assignRole($clientRole);
            $user->metas()->create([
                'meta_key' => 'user_position',
                'meta_value' => 'Cliente'
            ]);
        }

        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->get(route('users'))
            ->assertStatus(200);
            //->assertViewIs('admin.user.index')
            //->assertSee($theme->name);

        //$response = $this->get(route('users'));
        //$response->assertViewHas('admin.user.index', function ($viewUsers) use ($users) {
        //    return $viewUsers->count() === 10;
        //});
    }

    /**
     * Test that the index paginates users.
     * @return void
     */
    public function test_users_index_paginates_users()
    {
        $this->seed();
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('view menu');
        $adminUser = User::factory()->create();
        $adminUser->assignRole($role);
        $adminUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'admin'
        ]);

        $users = User::factory(30)->create();
        $clientRole = Role::where('name', 'client')->first();
        foreach ($users as $user){
            $user->assignRole($clientRole);
            $user->metas()->create([
                'meta_key' => 'user_position',
                'meta_value' => 'Cliente'
            ]);
        }

        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->get(route('users', ['paginate' => 25]))
            ->assertStatus(200)
            ->assertViewIs('admin.user.index');
            //->assertSee($theme->name);

        //$response = $this->get(route('users', ['paginate' => 25]));

        //$response->assertStatus(200);
        //$this->assertTrue($response->viewData('users')->count() <= 25);
    }
}
