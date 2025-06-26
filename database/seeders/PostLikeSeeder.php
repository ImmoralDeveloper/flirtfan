<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        if ($users->isEmpty() || $posts->isEmpty()) {
            $this->command->warn('No hay usuarios o posts disponibles para asignar likes.');
            return;
        }

        $likes = [];

        foreach ($users as $user) {
            // Cada usuario dará like a entre 1 y 10 posts aleatorios
            $likedPosts = $posts->random(rand(1, min(10, $posts->count())));

            foreach ($likedPosts as $post) {
                $likes[] = [
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insertar evitando duplicados por el índice único
        PostLike::insertOrIgnore($likes);
    }
}
