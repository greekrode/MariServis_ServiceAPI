<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="inventory",
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
 *       property="harga",
 *       type="decimal"
 *   ),
 *   @SWG\Property(
 *       property="qty",
 *       type="integer"
 *   ),
 *   @SWG\Property(
 *       property="category_id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="created_at",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="updated_at",
 *       type="string"
 *   ),
 * )
 */
class Inventory extends Model
{
    protected $fillable = [
      'nama',
      'harga',
      'qty',
      'category_id',
    ];

    protected $hidden = [
  
    ];

    public function category() {
        return $this->belongsTo("App\Category", "category_id");
    }

    public function services() {
        return $this->belongsToMany("App\Service", "inventory_service");
    }
}
