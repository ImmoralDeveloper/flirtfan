<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Evita combinaciones duplicadas
        $pairs = [];

        for ($i = 0; $i < 100; $i++) {
            // Elegir dos usuarios distintos
            $user1 = null;
            if ($i < 10) {
                $user1 = User::firstWhere('username', 'test_user');
            } else if ($i < 20) {
                $user1 = User::firstWhere('username', 'test_performer');
            } else if ($i < 30) {
                $user1 = User::firstWhere('username', 'test_admin');
            } else if ($i < 40) {
                $user1 = User::firstWhere('username', 'test_moderator');
            } else {
                $user1 = $users->random();
            }
            do {
                $user2 = $users->random();
            } while ($user1->id === $user2->id);

            // Asegurar orden para evitar duplicados
            $ids = [$user1->id, $user2->id];
            sort($ids);
            $key = implode('-', $ids);
            if (in_array($key, $pairs)) {
                continue;
            }
            $pairs[] = $key;

            // Crear conversación
            $conversation = Conversation::create([
                'user_one_id' => $ids[0],
                'user_two_id' => $ids[1],
            ]);

            // Crear entre 5 y 12 mensajes
            $messageCount = rand(5, 12);
            for ($j = 0; $j < $messageCount; $j++) {
                $sender = rand(0, 1) ? $user1 : $user2;

                $hasMedia = rand(0, 1);
                // si hay media puede haber o no haber texto, pero si no hay media si debe haber texto, lo mismo en viceversa
                $hasText = !$hasMedia || rand(0, 1);
                $media = $hasMedia ? [
                    fake()->imageUrl(640, 480),
                    fake()->randomElement([
                        null,
                        fake()->imageUrl(640, 480),
                        fake()->url() . '/video.mp4',
                    ])
                ] : null;

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $sender->id,
                    'body' => $hasText ? fake()->sentence() : null,
                    'media' => $media ? array_filter($media) : null,
                    'is_read' => rand(0, 1),
                    'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                ]);
            }
        }
    }
}
