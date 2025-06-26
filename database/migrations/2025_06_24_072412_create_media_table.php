<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['image', 'video'])->index();
            $table->string('path');
            $table->string('thumbnail')->nullable();
            $table->integer('size')->nullable();
            $table->enum('orientation', ['horizontal', 'vertical', 'square'])->nullable()->index();
            $table->decimal('duration', 8, 2)->nullable()->index();
            $table->json('metadata')->nullable(); // resolución, etc.
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['post_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
