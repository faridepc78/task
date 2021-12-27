<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    /*START CHECK INDEX*/

    public function test_admin_can_see_users_index()
    {
        $this->actionAsAdmin();
        $this->get(route('users.index'))->assertOk();
    }

    public function test_user_without_login_can_not_see_users_index()
    {
        $this->get(route('users.index'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_users_index()
    {
        $this->actionAsUser();
        $this->get(route('users.index'))->assertStatus(403);
    }

    /*END CHECK INDEX*/


    /*START CHECK CREATE*/

    public function test_admin_can_see_create_users()
    {
        $this->actionAsAdmin();
        $this->get(route('users.create'))->assertOk();
    }

    public function test_user_without_login_can_not_see_create_users()
    {
        $this->get(route('users.create'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_create_users()
    {
        $this->actionAsUser();
        $this->get(route('users.create'))->assertStatus(403);
    }

    /*END CHECK CREATE*/


    /*START CHECK STORE*/

    public function test_admin_can_store_users()
    {
        $this->actionAsAdmin();
        $response = $this->post(route('users.store'), $this->userData());
        $response->assertStatus(302);
        $response->assertRedirect(route('users.create'));
        $this->assertEquals(1, User::whereRole(User::USER)->count());
    }

    public function test_user_without_login_can_not_store_users()
    {
        $response = $this->post(route('users.store'), $this->userData());
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertEquals(0, User::whereRole(User::USER)->count());
    }

    public function test_user_with_login_can_not_store_users()
    {
        $this->actionAsUser();
        $response = $this->post(route('users.store'), $this->userData());
        $response->assertStatus(403);
        $this->assertEquals(1, User::whereRole(User::USER)->count());
    }

    /*END CHECK STORE*/


    /*START CHECK EDIT*/

    public function test_admin_can_see_edit_users()
    {
        $this->actionAsAdmin();
        $user = $this->createUser();
        $this->get(route('users.edit', $user->id))->assertOk();
    }

    public function test_user_without_login_can_not_see_edit_users()
    {
        $user = $this->createUser();
        $this->get(route('users.edit', $user->id))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_edit_users()
    {
        $this->actionAsUser();
        $user = $this->createUser();
        $this->get(route('users.edit', $user->id))->assertStatus(403);
    }

    /*END CHECK EDIT*/


    /*START CHECK UPDATE*/

    public function test_admin_can_update_users()
    {
        $this->actionAsAdmin();
        $user = $this->createUser();
        $this->patch(route('users.update', $user->id), [
            'f_name' => 'test',
            'l_name' => $this->faker->unique->lastName,
            'email' => $this->faker->unique->safeEmail,
            'password' => bcrypt('12345678')
        ])->assertStatus(302)->assertRedirect(route('users.edit', $user->id));
        $this->assertEquals('test', $user->fresh()->f_name);
    }

    public function test_user_without_login_can_not_update_users()
    {
        $user = $this->createUser();
        $this->patch(route('users.update', $user->id), [
            'f_name' => 'test',
            'l_name' => $this->faker->unique->lastName,
            'email' => $this->faker->unique->safeEmail,
            'password' => bcrypt('12345678')
        ])->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_update_users()
    {
        $this->actionAsUser();
        $user = $this->createUser();
        $this->patch(route('users.update', $user->id), [
            'f_name' => 'test',
            'l_name' => $this->faker->unique->lastName,
            'email' => $this->faker->unique->safeEmail,
            'password' => bcrypt('12345678')
        ])->assertStatus(403);
    }

    /*END CHECK UPDATE*/


    /*START CHECK DESTROY*/

    public function test_admin_can_delete_users()
    {
        $this->actionAsAdmin();
        $user = $this->createUser();
        $this->delete(route('users.destroy', $user->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));
        $this->assertEquals(0, User::whereRole(User::USER)->count());
    }

    public function test_user_without_login_can_not_delete_users()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $user = $this->createUser();
        $this->delete(route('users.destroy', $user->id))
            ->assertStatus(302)->assertRedirect(route('login'));
        $this->assertEquals(1, User::whereRole(User::USER)->count());
    }

    public function test_user_with_login_can_not_delete_users()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actionAsUser();
        $user = $this->createUser();
        $this->delete(route('users.destroy', $user->id))
            ->assertStatus(403);
        $this->assertEquals(1, User::whereRole(User::USER)->count());
    }

    /*END CHECK DESTROY*/


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

    private function createUser()
    {
        $data = $this->userData();
        return User::query()->create($data);
    }

    private function userData()
    {
        return [
            'f_name' => $this->faker->unique->firstName,
            'l_name' => $this->faker->unique->lastName,
            'email' => $this->faker->unique->safeEmail,
            'password' => bcrypt('12345678')
        ];
    }
}
