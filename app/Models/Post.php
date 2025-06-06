<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'image',
    ];

    /**
     * post with uset
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get if user has reacted
     */
    public function reaction()
    {
        return $this->hasMany(Reactions::class);
    }
}
