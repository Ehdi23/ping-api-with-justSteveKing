<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

final class UserFactory extends Factory
{
    /** @var class-string<Model> */
    protected $model = User::class;
    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(
            state: fn(array $attributes): array => [
                'email_verified_at' => null,
            ],
        );
    }
}