<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\StoryView;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $performers = User::where('role', 'performer')->get();
        $viewers = User::where('role', '!=', 'performer')->get(); // quienes pueden ver

        foreach ($performers as $performer) {
            $storyCount = rand(1, 3); // cada performer puede tener 1-3 historias

            for ($i = 0; $i < $storyCount; $i++) {
                $isVideo = rand(0, 1) === 1;

                $media = [
                    'url' => 'https://cdn.tusitio.com/' . Str::random(40),
                    'type' => $isVideo ? 'video/mp4' : 'image/jpeg',
                ];

                $story = Story::create([
                    'user_id' => $performer->id,
                    'media' => $media,
                    'views' => 0, // se actualizará luego
                ]);

                // Simular vistas de usuarios (10-30%)
                $viewedBy = $viewers->random(rand(0, intval($viewers->count() * 0.3)));

                foreach ($viewedBy as $viewer) {
                    StoryView::create([
                        'user_id' => $viewer->id,
                        'story_id' => $story->id,
                        'viewed_at' => now()->subMinutes(rand(0, 60 * 24)), // dentro de las últimas 24h
                    ]);
                }

                // Actualizar contador de vistas
                $story->views = $story->views()->count();
                $story->save();
            }
        }
    }
}
