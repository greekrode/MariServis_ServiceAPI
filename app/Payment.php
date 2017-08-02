<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="payment",
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
 * )
 */
class Payment extends Model
{// payment method here

    protected $fillable = [
      'nama'
    ];

    protected $hidden =[
      'created_at','updated_at'
    ];

    public function services() {
        return $this->hasMany("App\Service", "payment_id");
    }
}
