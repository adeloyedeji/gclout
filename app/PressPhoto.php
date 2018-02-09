<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PressPhoto extends Model
{
    protected $fillable = [
        'photo'
    ];

    public $with = [
        'press'
    ];

    public function getPhotoAttribute($photo) {
        return asset(\Storage::url($photo));
    }

    public function press() {
        return $this->belongsTo(Press::class, 'id', $this->press_id);
    }
}
