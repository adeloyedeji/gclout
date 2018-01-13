<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model
{
    //
    protected $fillable = ['post_id', 'photo'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function getPhotoAttribute($photo) {
        return asset(\Storage::url($photo));
    }
}
