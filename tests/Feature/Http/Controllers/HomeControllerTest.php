<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $this->post('contacto', $data)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Gracias por interesarse en nuestros servicios. En breve nos pondremos en contacto con usted.');

        $this->assertDatabaseHas('contact_messages', $data);
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
