<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Press extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'body', 'total_view'
    ];

    public $with = [
        'user', 'photos', 'likes'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function photos() {
        return $this->hasMany(PressPhoto::class);
    }

    public function likes() {
        return $this->hasMany(PressLike::class);
    }
}
