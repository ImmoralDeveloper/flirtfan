<?php

namespace Database\Seeders;

use App\Models\FollowingUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $users = User::all();

        // Nos aseguramos de que hay suficientes usuarios
        if ($users->count() < 2) {
            $this->command->warn('Se necesitan al menos 2 usuarios para relaciones de seguimiento.');
            return;
        }

        $followings = [];

        foreach ($users as $follower) {
            // Cada usuario sigue entre 1 y 5 usuarios (al azar)
            $followTargets = $users
                ->where('id', '!=', $follower->id) // no se sigue a sí mismo
                ->random(rand(1, min(5, $users->count() - 1)))
                ->pluck('id')
                ->toArray();

            foreach ($followTargets as $followingId) {
                $followings[] = [
                    'follower_id' => $follower->id,
                    'following_id' => $followingId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insertamos evitando duplicados por la unique key
        FollowingUser::insertOrIgnore($followings);
    }
}
