<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_in_database(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $response = $this->post('/register', [
            'role' => 'learner',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'dob' => '2000-01-01',
            'address' => 'Kuala Lumpur',
            'phone' => '0123456789',
            'id_number' => 'MY1234567',
            'country' => 'Malaysia',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'education_level' => 'bachelor',
            'interest_category' => 'programming',
            'learning_objectives' => 'Learn backend development',
            'approve_policy' => 'on',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'role' => 'learner',
            'approve_policy' => 1,
        ]);
    }

    public function test_login_redirects_to_dashboard_when_credentials_are_valid(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'learner',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '2000-01-01',
            'address' => 'Kuala Lumpur',
            'phone' => '0199999999',
            'id_number' => 'MY7654321',
            'country' => 'Malaysia',
            'approve_policy' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.1'));
        $this->assertAuthenticated();
    }
}
