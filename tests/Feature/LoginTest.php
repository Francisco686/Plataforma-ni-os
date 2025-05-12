<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_iniciar_sesion_con_credenciales_correctas()
    {
        // Crear un usuario
        $user = User::factory()->create([
            'name' => 'alumno123',
            'password' => bcrypt('12345678'),
        ]);

        // Enviar datos al login
        $response = $this->post('/login', [
            'name' => 'alumno123',
            'password' => '12345678',
        ]);

        // Verificar redirección correcta
        $response->assertRedirect('/home'); // O donde redirijas al iniciar sesión

        // Verificar que el usuario esté autenticado
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_falla_con_credenciales_invalidas()
    {
        // Usuario real
        $user = User::factory()->create([
            'name' => 'alumno456',
            'password' => bcrypt('12345678'),
        ]);

        // Intento con contraseña incorrecta
        $response = $this->post('/login', [
            'name' => 'alumno456',
            'password' => 'clave_incorrecta',
        ]);

        $response->assertSessionHasErrors(); // Verifica errores de validación
        $this->assertGuest(); // Asegura que no haya sesión activa
    }
}
