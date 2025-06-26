<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 posts con factory
        Post::factory()
            ->count(35)
            ->create()
            ->each(function ($post) {
                if ($post->payment_required) {
                    PostPrice::create([
                        'post_id' => $post->id,
                        'price' => fake()->randomFloat(2, 1.99, 19.99),
                        'currency' => 'USD',
                    ]);
                }
            });
    }
}
