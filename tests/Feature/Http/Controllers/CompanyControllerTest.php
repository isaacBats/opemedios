<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\{Company, Turn, User};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function the_admin_user_can_see_the_list_of_companies()
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

        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->get(route('companies'))
            ->assertStatus(200)
            ->assertViewIs('admin.company.index');
    }

    /** @test */
    public function the_manager_user_can_see_the_list_of_companies()
    {
        $this->seed();
        $role = Role::where('name', 'manager')->first();
        $role->givePermissionTo('view menu');
        $managerUser = User::factory()->create();
        $managerUser->assignRole($role);
        $managerUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'Manager'
        ]);

        $this->actingAs($managerUser)
            ->get(route('companies'))
            ->assertStatus(200)
            ->assertViewIs('admin.company.index');
    }

    /** @test */
    public function the_monitor_user_can_not_see_the_list_of_companies()
    {
        $this->seed();
        $role = Role::where('name', 'monitor')->first();
        $monitorUser = User::factory()->create();
        $monitorUser->assignRole($role);
        $monitorUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'Monitor'
        ]);

        $this->actingAs($monitorUser)
            ->get(route('companies'))
            ->assertStatus(403);
    }

    /** @test */
    public function the_admin_user_can_create_a_company()
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

        $turn = Turn::factory()->create();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('logo.jpg');

        $formData = [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario',
            'turn_id' => $turn->id,
            'logo' => $file,
            'digital_properties' => [
                'face' => 'https://facebook.com/opemedios',
                'insta' => 'https://www.instagram.com/opemedios'
            ]
        ];
        /** @var User $adminUser */
        $this->actingAs($adminUser)
            ->post(route('company.create'), $formData)
            ->assertStatus(302)
            ->assertSessionHas(
                'alert-success',
                'La empresa se ha creado con éxito'
            );

        $this->assertDatabaseHas('companies', [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario'
        ]);
    }

    /** @test */
    public function the_manager_user_can_create_company()
    {
        $this->seed();
        $role = Role::where('name', 'manager')->first();
        $role->givePermissionTo('view menu');
        $managerUser = User::factory()->create();
        $managerUser->assignRole($role);
        $managerUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'manager'
        ]);

        $turn = Turn::factory()->create();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('logo.jpg');

        $formData = [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario',
            'turn_id' => $turn->id,
            'logo' => $file,
            'digital_properties' => [
                'face' => 'https://facebook.com/opemedios',
                'insta' => 'https://www.instagram.com/opemedios'
            ]
        ];
        /** @var User $managerUser */
        $this->actingAs($managerUser)
            ->post(route('company.create'), $formData)
            ->assertStatus(302)
            ->assertSessionHas(
                'alert-success',
                'La empresa se ha creado con éxito'
            );

        $this->assertDatabaseHas('companies', [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario'
        ]);
    }

    /** @test */
    public function the_monitor_user_can_not_create_company()
    {
        $this->seed();
        $role = Role::where('name', 'monitor')->first();
        $monitorUser = User::factory()->create();
        $monitorUser->assignRole($role);
        $monitorUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'monitor'
        ]);

        $turn = Turn::factory()->create();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('logo.jpg');

        $formData = [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario',
            'turn_id' => $turn->id,
            'logo' => $file,
            'digital_properties' => [
                'face' => 'https://facebook.com/opemedios',
                'insta' => 'https://www.instagram.com/opemedios'
            ]
        ];
        /** @var User $monitorUser */
        $this->actingAs($monitorUser)
            ->post(route('company.create'), $formData)
            ->assertStatus(403);

        $this->assertDatabaseMissing('companies', [
            'name' => 'Nueva empresa',
            'address' => 'Avenida Centenario'
        ]);
    }

    /** @test */
    public function admin_user_can_see_company()
    {
        $this->withExceptionHandling();
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('view menu');
        $adminUser = User::factory()->create();
        $adminUser->assignRole($role);
        $adminUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'admin'
        ]);
        /** @var User $adminUser */
        $company = Company::first();
        $this->actingAs($adminUser)
            ->get(route('company.show', ['company' => $company]))
            ->assertStatus(200)
            ->assertViewIs('admin.company.show')
            ->assertSee($company->name);
    }

    /** @test */
    public function manager_user_can_see_company()
    {
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'manager')->first();
        $role->givePermissionTo('view menu');
        $managerUser = User::factory()->create();
        $managerUser->assignRole($role);
        $managerUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'manager'
        ]);

        $company = Company::all()->random();
        $this->actingAs($managerUser)
            ->get(route('company.show', ['company' => $company]))
            ->assertStatus(200)
            ->assertViewIs('admin.company.show')
            ->assertSee($company->name);
    }

    /** @test */
    public function monitor_user_can_not_see_company()
    {
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'monitor')->first();
        $monitorUser = User::factory()->create();
        $monitorUser->assignRole($role);
        $monitorUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'monitor'
        ]);

        $company = Company::all()->random();
        $this->actingAs($monitorUser)
            ->get(route('company.show', ['company' => $company]))
            ->assertStatus(403);
    }

    /** @test */
    public function the_admin_user_can_update_a_company()
    {
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('view menu');
        $adminUser = User::factory()->create();
        $adminUser->assignRole($role);
        $adminUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'admin'
        ]);
        $company = Company::all()->random();
        $inputs = [
            'name' => 'Empresa editada',
            'address' => 'Av Siempre viva #43',
            'turn_id' => $company->turn_id
        ];

        $this->actingAs($adminUser)
            ->post(route('company.update', ['id' => $company->id]), $inputs)
            ->assertStatus(302)
            ->assertRedirect(route('company.show', ['company' => $company]))
            ->assertSessionHas('status', '¡Exito!. Datos actualizados');

        $this->assertDatabaseHas('companies', $inputs);
    }

    /** @test */
    public function the_manager_user_can_update_a_company()
    {
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'manager')->first();
        $role->givePermissionTo('view menu');
        $managerUser = User::factory()->create();
        $managerUser->assignRole($role);
        $managerUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'manager'
        ]);
        $company = Company::all()->random();
        $inputs = [
            'name' => 'Empresa editada',
            'address' => 'Av Siempre viva #43',
            'turn_id' => $company->turn_id
        ];

        $this->actingAs($managerUser)
            ->post(route('company.update', ['id' => $company->id]), $inputs)
            ->assertStatus(302)
            ->assertRedirect(route('company.show', ['company' => $company]))
            ->assertSessionHas('status', '¡Exito!. Datos actualizados');

        $this->assertDatabaseHas('companies', $inputs);
    }

    /** @test */
    public function the_monitor_user_can_not_update_a_company()
    {
        $this->seed();
        Company::factory(10)->create();
        $role = Role::where('name', 'monitor')->first();
        $monitorUser = User::factory()->create();
        $monitorUser->assignRole($role);
        $monitorUser->metas()->create([
            'meta_key' => 'user_position',
            'meta_value' => 'monitor'
        ]);
        $company = Company::all()->random();
        $inputs = [
            'name' => 'Empresa editada',
            'address' => 'Av Siempre viva #43',
            'turn_id' => $company->turn_id
        ];

        $this->actingAs($monitorUser)
            ->post(route('company.update', ['id' => $company->id]), $inputs)
            ->assertStatus(403);

        $this->assertDatabaseMissing('companies', $inputs);
    }
}
