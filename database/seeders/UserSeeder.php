<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create()
            ->each(function ($user) {
                $team = Team::factory()->create();
                $user->teams()->attach($team->id, ['role' => 'member']); // Especifica el role
            });
    }
}
