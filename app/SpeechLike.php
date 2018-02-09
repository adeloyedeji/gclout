<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SpeechLike extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'speeches_id', 'user_id'
    ];

    public $with = [
        'speech', 'user'
    ];

    public function speech() {
        return $this->belongsTo(Speech::class, 'id', $this->speeches_id);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', $this->id);
    }
}
