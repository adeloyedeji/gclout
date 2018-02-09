<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PetitionImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo'
    ];

    public $with = [
        'petition'
    ];

    public function getPhotoAttribute($photo) {
        return asset(\Storage::url($photo));
    }

    public function petition() {
        return $this->belongsTo(Petition::class);
    }
}
