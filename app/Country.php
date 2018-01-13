<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = ['country'];

    public function state() {
        return $this->hasMany(State::class);
    }

    public function profile() {
        return $this->hasMany(Profile::class);
    }
}
