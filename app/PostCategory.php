<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category'
    ];

    public $with = [
        'user'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
