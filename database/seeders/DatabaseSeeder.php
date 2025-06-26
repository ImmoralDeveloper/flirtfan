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

        // Cargar performers desde el JSON y crear usuarios performer
        $performers = json_decode(file_get_contents(database_path('seeders/performers.json')), true);
        foreach ($performers as $key => $data) {
            User::factory()->performer($key, $data)->create();
        }

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'test_user',
            'email' => 'test@example.com',
        ]);
        User::factory()->performer('test_performer', [
            'title' => 'Test Performer',
            'website' => null,
            'social_networks' => [],
        ])->create([
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
            MediaSeeder::class,
        ]);
    }
}
