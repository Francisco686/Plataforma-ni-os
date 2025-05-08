<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_registrarse_correctamente()
    {
        $response = $this->post('/register', [
            'name' => 'nuevoalumno',
            'password' => 'clave123',
            'password_confirmation' => 'clave123',
        ]);

        // Verifica redirección (puede ser a /home u otra)
        $response->assertRedirect('/home');

        // Verifica que el usuario se haya creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => 'nuevoalumno',
        ]);

        // Verifica que esté autenticado
        $this->assertAuthenticated();
    }

    public function test_no_puede_registrarse_con_passwords_diferentes()
    {
        $response = $this->post('/register', [
            'name' => 'otroalumno',
            'password' => 'clave123',
            'password_confirmation' => 'otra_clave',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_no_puede_registrarse_sin_nombre()
    {
        $response = $this->post('/register', [
            'name' => '',
            'password' => 'clave123',
            'password_confirmation' => 'clave123',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertGuest();
    }
}
