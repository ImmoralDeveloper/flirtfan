<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigratePerformerMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:performer-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of performer media...');

        $basePath = public_path('performers');
        $usersPath = storage_path('app/public/uploads/users');

        $performers = File::directories($basePath);

        foreach ($performers as $path) {
            $username = basename($path);
            $user = \App\Models\User::where('username', $username)->first();

            if (!$user) {
                $this->warn("User '$username' not found. Skipping...");
                continue;
            }

            $userId = $user->id;
            $destination = $usersPath . "/{$userId}";

            // Mover avatar
            if (File::exists("$path/avatar")) {
                File::copyDirectory("$path/avatar", "$destination/avatar");
            }

            // Mover fotos
            if (File::exists("$path/photos")) {
                File::copyDirectory("$path/photos", "$destination/images");
            }

            // Mover videos
            if (File::exists("$path/videos")) {
                File::makeDirectory("$destination/videos", 0755, true, true);
                File::copyDirectory("$path/videos", "$destination/videos");
            }

            $this->info("Migrated media for user '{$username}' → ID {$userId}");
        }

        $this->info('Migration completed.');
    }

}
