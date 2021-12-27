<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'f_name' => $this->faker->unique()->firstName(),
            'l_name' => $this->faker->unique->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('12345678'),
            'role' => User::USER
        ];
    }
}
