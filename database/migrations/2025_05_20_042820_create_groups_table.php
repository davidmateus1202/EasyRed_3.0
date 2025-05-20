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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del grupo
            $table->text('description')->nullable(); // Descripción del grupo
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade'); // El usuario que creó el grupo
            $table->string('slug')->unique(); // Para URLs amigables
            $table->boolean('is_private')->default(false); // Si el grupo es privado o público
            $table->string('cover_image_path')->nullable(); // Ruta a una imagen de portada para el grupo
            $table->timestamps(); // created_at y updated_at

            // Considera un índice para el nombre si se busca frecuentemente por él, aunque el slug ya es único.
            // $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};