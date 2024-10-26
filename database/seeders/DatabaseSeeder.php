<?php

declare(strict_types=1);

namespace Database\Seeders;

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
        ]);

        Service::factory()->for($user)->count(1000)->create();
    }
}
