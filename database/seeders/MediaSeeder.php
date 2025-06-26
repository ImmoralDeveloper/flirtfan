<?php

namespace Database\Seeders;

use App\Models\PostPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;
use App\Models\Media;
class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/performers.json');

        if (!File::exists($jsonPath)) {
            $this->command->error('performers.json not found.');
            return;
        }

        $performers = json_decode(File::get($jsonPath), true);

        foreach ($performers as $username => $data) {
            $user = User::where('username', $username)
                ->where('role', 'performer')
                ->first();

            if (!$user) {
                $this->command->warn("User not found or not a performer: $username");
                continue;
            }

            $images = $data['photos'] ?? [];
            $videos = $data['videos'] ?? [];

            shuffle($images);
            shuffle($videos);

            $mediaCount = count($images) + count($videos);
            if ($mediaCount === 0) {
                continue;
            }

            // Calcular cuántos posts crear en base a los medios
            $totalPosts = ceil($mediaCount / 5); // Promedio 5 por post

            for ($i = 0; $i < $totalPosts; $i++) {
                $post = Post::factory()->create([
                    'user_id' => $user->id,
                ]);

                if ($post->payment_required) {
                    PostPrice::create([
                        'post_id' => $post->id,
                        'price' => fake()->randomFloat(2, 1.99, 19.99),
                        'currency' => 'USD',
                    ]);
                }

                // Agregar hasta 6 imágenes
                $numImages = rand(0, min(6, count($images)));
                $postImages = array_splice($images, 0, $numImages);

                foreach ($postImages as $photo) {
                    Media::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'type' => 'image',
                        'path' => "uploads/users/{$user->id}/images/{$photo}",
                        'thumbnail' => "uploads/users/{$user->id}/images/small/{$photo}.webp",
                        'size' => null,
                        'orientation' => null,
                        'duration' => null,
                        'metadata' => null,
                    ]);
                }

                // Agregar máximo 1 video por post
                if (count($videos) > 0 && rand(0, 1)) {
                    $video = array_shift($videos);
                    $meta = $video['metadata'] ?? [];
                    $mediaName = explode('.', $video['filename'])[0];
                    $thumbnail = "uploads/users/{$user->id}/videos/posters/{$mediaName}_1.webp";
                    Media::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'type' => 'video',
                        'path' => "uploads/users/{$user->id}/videos/{$video['filename']}",
                        'thumbnail' => $thumbnail,
                        'size' => $meta['size'] ?? null,
                        'orientation' => $meta['orientation'] ?? null,
                        'duration' => $meta['duration'] ?? null,
                        'metadata' => json_encode([
                            'width' => $meta['width'] ?? null,
                            'height' => $meta['height'] ?? null,
                        ]),
                    ]);
                }

                $this->command->info("Created post with media for performer: $username");
            }

        }
    }
}