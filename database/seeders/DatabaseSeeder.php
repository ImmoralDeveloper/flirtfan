<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        User::factory()->count(20)->performer()->create();

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'test_user',
            'email' => 'test@example.com',
        ]);
        User::factory()->performer()->create([
            'name' => 'Test Performer',
            'username' => 'test_performer',
            'email' => 'performer@example.com',
        ]);
        User::factory()->admin()->create([
            'name' => 'Test Admin',
            'username' => 'test_admin',
            'email' => 'admin@example.com',
        ]);
        User::factory()->moderator()->create([
            'name' => 'Test Moderator',
            'username' => 'test_moderator',
            'email' => 'moderator@example.com',
        ]);

        $this->call([
            PostSeeder::class,
            FollowingUsersSeeder::class,
            PostLikeSeeder::class,
            PostCommentSeeder::class,
            ConversationSeeder::class,
            StorySeeder::class,
        ]);

    }
}
