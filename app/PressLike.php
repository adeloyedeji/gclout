<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PressLike extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'press_id'
    ];

    public $with = [
        'press', 'user'
    ];

    public function press() {
        return $this->belongsTo(Press::class, 'id', $this->press_id);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', $this->id);
    }
}
