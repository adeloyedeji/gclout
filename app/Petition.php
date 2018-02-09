<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Petition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'body', 'category', 'target_arm', 'target_number', 'time_frame'
    ];

    public $with = [
        'photos'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id', $this->user_id);
    }

    public function photos() {
        return $this->hasMany(PetitionImage::class);
    }
}
