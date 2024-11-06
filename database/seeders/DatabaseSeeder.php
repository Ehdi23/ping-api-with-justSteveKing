<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'El Hadi El Gholem',
            'email' => 'egholem@gmail.com',
            'password' => 'Mouloudia2010.'
        ]);

        $service = Service::factory()->for($user)->create([
            'name' => 'Treblle API',
            'url' => 'https://api.treblle.com'
        ]);

        Check::factory()->for($service)->create([
            'name' => 'Root Check',
            'path' => '/',
            'method' => 'GET',
            'headers' => [
                'User-Agent' => 'Treblle Ping Service 1.0.0',
            ],
        ]);
    }
}
