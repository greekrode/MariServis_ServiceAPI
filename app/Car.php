<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   definition="car",
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
 *       property="updated_at",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="jenis",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="no_plat",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="model",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="customer_id",
 *       type="integer"
 *   ),
 * )
 */

class Car extends Model
{
    protected $fillable = [
        'nama',
        'jenis',
        'no_plat',
        'model',
    ];

    public function customer() {
        return $this->belongsTo("App\Customer", "customer_id");
    }

    public function services() {
        return $this->hasMany("App\Service", "car_id");
    }
}
