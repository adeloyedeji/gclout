<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    protected $fillable = [
        'state', 'capital'
    ];

    public function lga() {
        return $this->hasMany(Lga::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function profile() {
        return $this->hasMany(Profile::class);
    }
}
