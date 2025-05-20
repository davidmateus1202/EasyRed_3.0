<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // Grupo al que pertenece el post
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que creó el post
            $table->text('content'); // Contenido del post
            $table->string('type')->default('text'); // Tipo de post (e.g., 'text', 'image', 'file_link', 'video_link')
            $table->string('media_url')->nullable(); // URL para el contenido multimedia si 'type' no es 'text'
            $table->timestamps(); // created_at y updated_at

            // Índices para búsquedas eficientes
            $table->index('group_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_posts');
    }
};