<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'status'
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }
    
    public function interactions()
    {
        return $this->hasMany(PostInteraction::class);
    }

    public function views()
    {
        return $this->interactions()->where('interaction_type', 'view');
    }

    public function likes()
    {
        return $this->interactions()->where('interaction_type', 'like');
    }

    public function comments()
    {
        return $this->interactions()->where('interaction_type', 'comment');
        return $this->hasMany(Comment::class);
    }
    
}

