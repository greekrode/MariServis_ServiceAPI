<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="customer",
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
 *       property="alamat",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="no_telp",
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
class Customer extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'no_telp',
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function cars() {
        return $this->hasMany("App\Car", "customer_id");
    }

    public  function services() {
        return $this->hasMany("App\Service", "customer_id");
    }

    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }
}
