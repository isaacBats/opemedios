<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

    /**
     * est for statics pages in the front.
     *
     * @return void
     */
    
    public function test_static_pages()
    {
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Expertos en monitoreo');
        
        $this->get(route('about'))
            ->assertStatus(200)
            ->assertSee('Quiénes Somos');
        
        $this->get(route('clients'))
            ->assertStatus(200)
            ->assertSee('Nuestros Clientes');
        
        $this->get(route('contact'))
            ->assertStatus(200)
            ->assertSee('Contáctanos');

        $this->get(route('signin'))
            ->assertStatus(200)
            ->assertSee('Entra a tu cuenta')
            ->assertSee('Correo');
    }

    public function test_save_contact_form()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify('##########'),
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertSessionHas(
                'status',
                'Gracias por interesarse en nuestros servicios. En breve nos pondremos en contacto con usted.'
            );

        $this->assertDatabaseHas('contact_messages', $data);
    }

    public function test_contact_form_name_is_required()
    {
        $data = [
            'name' => "",
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify('##########'),
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'name' => 'Queremos conocerte. Por favor ingresa tu nombre.',
            ]);
    }

    public function test_contact_form_email_is_required()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => '',
            'phone' => $this->faker->numerify('##########'),
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'email' => 'Dejanos una dirección de correo para poder estar en contacto contigo.',
            ]);
    }

    public function test_contact_form_email_must_be_valid()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => 'email not valid',
            'phone' => $this->faker->numerify('##########'),
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'email' => 'Ingresa una dirección de correo valida.',
            ]);
    }

    public function test_contact_form_phone_is_required()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '',
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'phone' => 'Si nos dejas tu número de teléfono, podemos contactarte mas rápido.',
            ]);
    }

    public function test_contact_form_phone_only_numbers()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => 'ljhgdsdred',
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'phone' => 'Introduce un número valido de 10 dígitos',
            ]);
    }

    public function test_contact_form_phone_long_minimum()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '123456',
            'message' => $this->faker->text
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'phone' => 'Introduce un número valido de 10 dígitos',
            ]);
    }

    public function test_save_contact_form_message_is_required()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify('##########'),
            'message' => ''
        ];

        $this->from('contacto')->post('contacto', $data)
            ->assertStatus(302)
            ->assertRedirect('contacto')
            ->assertSessionHasErrors([
                'message' => 'Aquí puedes compartirnos tus dudas a cerca de nuestros servicios.',
            ]);
    }

    public function test_save_contact_form_policy()
    {
        $data = [];

        $this->post('contacto', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'Queremos conocerte. Por favor ingresa tu nombre.',
                'email' => 'Dejanos una dirección de correo para poder estar en contacto contigo.',
                'phone' => 'Si nos dejas tu número de teléfono, podemos contactarte mas rápido.',
            ]);
    }
}
