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
        $name = fake()->name();
        $username = Str::slug($name, '_');
        $username = Str::lower($username);
        return [
            'name' => fake()->name(),
            'username' => $username,
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

    public function performer()
    {
        return $this->state(fn() => ['role' => 'performer'])
            ->afterCreating(function ($user) {
                $user->performer()->create([
                    'website' => "https://immoral.dev",
                    'social_links' => json_encode([
                        'x' => "https://immoral.dev",
                        'instagram' => "https://immoral.dev",
                        'facebook' => "https://immoral.dev",
                        'email' => "https://immoral.dev",
                        'youtube' => "https://immoral.dev",
                        'tiktok' => "https://immoral.dev",
                        'twitch' => "https://immoral.dev",
                    ]),
                ]);
            });
    }
}
