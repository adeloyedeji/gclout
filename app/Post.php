<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'content', 'user_id', 'video', 'location'
    ];
    //Auth::user()->post()->create(['contnet' => 'whatever']); remove user_id fillable

    public $with = [
        'user', 'likes', 'comments', 'photos'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function photos() {
        return $this->hasMany(PostPhoto::class);
    }

    public function comments() {
        return $this->hasMany(PostComment::class)->latest();
    }
}
