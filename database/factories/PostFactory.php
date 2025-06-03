<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        $images_array = [1,2,3,4,5,6,7];
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'body' => $this->faker->paragraphs(3, true),
            'media' => [
                ["image" => "{$this->faker->randomElement($images_array)}.png"],
                ["image" => "{$this->faker->randomElement($images_array)}.png"],
                ["image" => "{$this->faker->randomElement($images_array)}.png"],
            ],
            'status' => $this->faker->randomElement(['published', 'draft', 'pending']),
            'subscription_required' => $this->faker->boolean(30),
            'payment_required' => $this->faker->boolean(50),
        ];
    }
}
