<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{

    protected $fillable = [
        'path','user_id'
    ];

    public function userimage() {
        return $this->belongsTo("App\User", "user_id");
    }
}
