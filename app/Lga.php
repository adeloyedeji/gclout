<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    //
    public $with = [
        'state'
    ];
    protected $fillable = ['lga', 'state_id'];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function profile() {
        return $this->hasMany(Profile::class);
    }
}
