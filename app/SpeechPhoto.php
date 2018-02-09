<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SpeechPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo', 'speeches_id'
    ];

    public function getPhotoAttribute($photo) {
        return asset(\Storage::url($photo));
    }

    public function speech() {
        return $this->belongsTo(Speech::class, 'id', $this->speeches_id);
    }
}
