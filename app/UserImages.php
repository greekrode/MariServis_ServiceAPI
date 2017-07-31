<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImages extends Model
{
    protected $fillable = [
        'path',
    ];

    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }
}
