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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que es miembro
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // Grupo al que pertenece
            $table->string('role')->default('member'); // Rol del usuario en el grupo (e.g., 'admin', 'moderator', 'member')
            $table->timestamp('joined_at')->useCurrent(); // Fecha en que se unió
            $table->timestamps(); // created_at (para cuando se creó la membresía) y updated_at

            // Un usuario solo puede ser miembro de un grupo una vez
            $table->unique(['user_id', 'group_id']);

            // Índices para búsquedas eficientes
            $table->index('user_id');
            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};