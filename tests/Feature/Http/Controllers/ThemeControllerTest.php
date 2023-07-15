<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\{Company, Theme, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ThemeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * The admin user can create a theme.
     *
     * @return void
     */
    public function test_admin_can_create_themes()
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
        $company = Company::factory()->create();

        $formData = [
            'name' => 'Test Nuevo tema',
            'description' => 'Descripción del tema nuevo',
            'company_id' => $company->id
        ];
        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->post(route('theme.create'), $formData)
            ->assertStatus(302)
            ->assertSessionHas(
                'status',
                "El tema: {$formData['name']} se ha creado satisfactoriamente!"
            );

        $this->assertDatabaseHas('themes', [
            'name' => 'Test Nuevo tema',
            'description' => 'Descripción del tema nuevo'
        ]);
    }

    /**
     * The admin user can show a theme.
     *
     * @return void
     */
    public function test_admin_can_show_theme()
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
        $company = Company::factory()->create();
        $theme = Theme::factory()->create([
            'company_id' => $company->id
        ]);

        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->get(route('theme.show', ['theme' => $theme->id]))
            ->assertStatus(200)
            ->assertViewIs('admin.theme.show')
            ->assertSee($theme->name);
    }

    /**
     * The admin user can't create a topic because some attribute is missing.
     *
     * @return void
     */
    public function test_admin_cant_create_topic_because_some_attribute_is_missing()
    {
        // $this->withoutExceptionHandling();
        $this->seed();
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('view menu');
        $adminUser = User::factory()->create();
        $adminUser->assignRole($role);
        $adminUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'admin'
        ]);
        $company = Company::factory()->create();

        $formData = [
            'name' => 'Test Nuevo tema',
            'company_id' => $company->id
        ];
        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->from(route('company.show', ['company' => $company]))
            ->post(route('theme.create'), $formData)
            ->assertRedirect(route('company.show', ['company' => $company]))
            ->assertSessionHasErrors();

        $this->assertDatabaseMissing('themes', [
            'name' => 'Test Nuevo tema',
            'description' => 'Descripción del tema nuevo'
        ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_update_themes()
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
        $company = Company::factory()->create();
        $theme = Theme::factory()->create([
            'company_id' => $company->id
        ]);

        $formData = [
            'name' => $theme->name,
            'description' => 'Descripción del tema Editado',
            'company_id' => $theme->company_id
        ];

        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->post(route('theme.update', ['theme' => $theme->id]), $formData)
            ->assertStatus(302)
            ->assertSessionHas(
                'status',
                "¡El tema {$formData['name']} se a actualizado correctamente!"
            );

        $this->assertDatabaseHas('themes', [
            'name' => $theme->name,
            'description' => $formData['description']
        ]);
    }
}
