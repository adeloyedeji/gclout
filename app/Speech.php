<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Speech extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'body', 'total_views'
    ];

    public $with = [
        'user', 'likes', 'photos'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(SpeechLike::class, 'speeches_id');
    }

    public function photos() {
        return $this->hasMany(SpeechPhoto::class, 'speeches_id');
    }
}
