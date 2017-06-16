<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
      'nama',
      'harga',
      'qty',
      'category_id',
    ];

    protected $hidden = [
      'id',
      'category_id',
      'created_at',
      'updated_at',
    ];

    public function category() {
        return $this->belongsTo("App\Category", "category_id");
    }

    public function services() {
        return $this->belongsToMany("App\Service", "inventory_service");
    }
}
