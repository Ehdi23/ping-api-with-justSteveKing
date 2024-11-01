<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Check;
use App\Models\Service;
use App\Models\Credential;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CheckFactory extends Factory
{
    /** @var class-string<Model> */
    protected $model = Check::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'path' => $this->faker->filePath(),
            'method' => 'GET',
            'body' => null,
            'header' => null,
            'parameters' => null,
            'credential_id' => $this->faker->boolean()
                ? Credential::factory()
                : null,
            'service_id' => Service::factory(),
            // 'user_id' => User::factory(),
        ];
    }
}
