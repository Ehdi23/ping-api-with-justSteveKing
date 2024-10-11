<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ServiceFactory extends Factory
{
    /** @var class-string<Model> */
    protected $model = Service::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'url' => $this->faker->unique()->url(),
            'user_id' => User::factory(),
        ];
    }
}
