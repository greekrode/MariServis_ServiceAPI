<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="category",
 *   @SWG\Property(
 *       property="id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="nama",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="created_at",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="created_at",
 *       type="string"
 *   ),
 * )
 */
class Category extends Model
{
    protected $fillable = [
      'nama',
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];


    public function inventories() {
        return $this->hasMany("App\Inventory", "category_id");
    }
}
