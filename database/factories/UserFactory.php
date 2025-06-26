<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => Str::uuid(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'bio' => fake()->paragraph(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin()
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    public function moderator()
    {
        return $this->state(fn() => ['role' => 'moderator']);
    }

    public function performer(string $key, array $performerData)
    {
        return $this->state(function () use ($key, $performerData) {
            return [
                'name' => $performerData['title'],
                'username' => $key,
                'image' => 'profile.jpg',
                'cover' => storage_path('app/public/uploads/users/' . $key . '/images/normal/1.webp'),
                'email' => "{$key}@immoral.dev",
                'role' => 'performer',
                // Otros campos generados automáticamente
            ];
        })->afterCreating(function ($user) use ($performerData) {
            $user->performer()->create([
                'website' => $performerData['website'] ?? null,
                'social_links' => json_encode($performerData['social_networks'] ?? []),
            ]);
        });
    }
}
