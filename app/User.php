<?php

namespace App;

use \App\Traits\Cloutable;
use \App\Traits\Friendable;
use Laravel\Scout\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;
    // use Searchable;
    use Cloutable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'gender', 'avatar', 'cover'
    ];

    public $with = [
        'profile', 'petitions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function likes() {
        return $this->hasMany(Like::class)->latest();
    }

    public function postcomments() {
        return $this->hasMany(PostComment::class)->latest();
    }

    public function getAvatarAttribute($avatar) {
        return asset(\Storage::url($avatar));
    }

    public function getCoverAttribute($cover) {
        return asset(\Storage::url($cover));
    }

    public function state() {
        return $this->hasOne(State::class);
    }

    public function lga() {
        return $this->hasOne(Lga::class);
    }

    public function press() {
        return $this->hasMany(Press::class);
    }

    public function speech() {
        return $this->hasMany(Speech::class);
    }

    public function petitions() {
        return $this->hasMany(Petition::class, 'user_id', $this->id);
    }
}
