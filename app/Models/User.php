<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Descomenta si usas verificación de email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // implements MustVerifyEmail (si usas verificación de email)
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> // Cambiado de list<string> a array<int, string> para compatibilidad general
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',          // Tu campo existente
        'photo_banner',   // Tu campo existente
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string> // Cambiado de list<string> a array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // Método de casteo para Laravel 9+
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Ya lo tenías, correcto para Laravel 10+
        ];
    }
    // Si estás en Laravel < 9, usa la propiedad $casts en lugar del método:
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed', // o 'bcrypt' en versiones más antiguas de Laravel
    // ];

    // --- INICIO: Relaciones para Grupos de Estudio ---

    /**
     * Grupos que el usuario ha creado.
     */
    public function createdGroups()
    {
        return $this->hasMany(Group::class, 'creator_id');
    }

    /**
     * Grupos a los que el usuario pertenece (es miembro).
     * Se especifica la tabla pivot 'group_members' y las claves foráneas.
     */
    public function joinedGroups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')
                    ->withPivot('role', 'joined_at') // Incluye campos adicionales de la tabla pivot
                    ->withTimestamps(); // Asume que la tabla pivot 'group_members' tiene timestamps (created_at, updated_at)
    }

    /**
     * Publicaciones que el usuario ha hecho en cualquier grupo.
     */
    public function groupPosts()
    {
        return $this->hasMany(GroupPost::class, 'user_id');
    }

    // --- FIN: Relaciones para Grupos de Estudio ---
}