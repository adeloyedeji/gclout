<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionView extends Model
{
    protected $fillable = [
        'petition_id', 'user_id'
    ];

    public $with = [
        'petition', 'user'
    ];

    public function petition() {
        return $this->belongsTo(Petition::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
