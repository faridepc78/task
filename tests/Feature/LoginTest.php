<?php

namespace Tests\Feature;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_user_can_login_by_email()
    {
        // prevent validation error on captcha
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        // provide hidden input for your 'required' validation
        NoCaptcha::shouldReceive('display')
            ->zeroOrMoreTimes()
            ->andReturn('<input type="hidden" name="g-recaptcha-response" value="1" />');

        $user = User::create(
            [
                'f_name' => $this->faker->unique->firstName,
                'l_name' => $this->faker->unique->lastName,
                'email' => $this->faker->unique->safeEmail,
                'password' => bcrypt('12345678')
            ]
        );

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => '12345678',
            'g-recaptcha-response' => make_token(100)
        ]);

        $this->assertAuthenticated();
    }
}
