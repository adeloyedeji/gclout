<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    //
    protected $fillable = [
        'user_id', 'post_id', 'comments'
    ];

    public $with = [
        'user'
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
