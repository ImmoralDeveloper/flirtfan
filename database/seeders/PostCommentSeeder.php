<?php

namespace Database\Seeders;

use App\Models\CommentLike;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        // Creamos comentarios para cada post
        foreach ($posts as $post) {
            $commentCount = rand(2, 6); // Comentarios por post

            for ($i = 0; $i < $commentCount; $i++) {
                $commentingUser = $users->random();

                $comment = PostComment::create([
                    'post_id' => $post->id,
                    'user_id' => $commentingUser->id,
                    'body' => fake()->sentence(10),
                ]);

                // Likes para el comentario (de otros usuarios aleatorios)
                $likers = $users->where('id', '!=', $commentingUser->id)->random(rand(0, 5));

                foreach ($likers as $liker) {
                    CommentLike::create([
                        'comment_id' => $comment->id,
                        'user_id' => $liker->id,
                    ]);
                }
            }
        }
    }
}
