<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    public $with = [
        'state', 'country'
    ];
    protected $fillable = [
        'user_id',  'date_of_birth',  'about', 'address', 'state_id', 'lga_id', 'country_id', 'residence', 'phone_number', 'account_status', 'online_status', 'total_login', 'role', 'ward', 'job'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lga() {
        return $this->hasOne(Lga::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }
}
