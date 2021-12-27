<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_admin_can_see_dashboard()
    {
        $this->actionAsAdmin();
        $this->get(route('dashboard'))->assertOk();
    }

    public function test_user_without_login_can_not_see_dashboard()
    {
        $this->get(route('dashboard'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_dashboard()
    {
        $this->actionAsUser();
        $this->get(route('dashboard'))->assertStatus(403);
    }

    private function createUserData()
    {
        return User::query()
            ->create([
                'f_name' => $this->faker->unique->firstName,
                'l_name' => $this->faker->unique->lastName,
                'email' => $this->faker->unique->safeEmail,
                'password' => bcrypt('12345678')
            ]);
    }

    private function actionAsUser()
    {
        $this->actingAs($this->createUserData());
        auth()->check();
    }

    private function createAdminData()
    {
        return User::query()
            ->create([
                'f_name' => 'farid',
                'l_name' => 'shishebori',
                'email' => 'farid@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => User::ADMIN
            ]);
    }

    private function actionAsAdmin()
    {
        $this->actingAs($this->createAdminData());
        auth()->check();
    }
}
