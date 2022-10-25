<?php

namespace Cjmellor\Rating\Database\Factories;

use Cjmellor\Rating\Tests\Models\FakeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakeUserFactory extends Factory
{
    protected $model = FakeUser::class;

    public function definition(): array
    {
        return [
            'username' => fake()->userName,
            'password' => fake()->password,
        ];
    }
}
