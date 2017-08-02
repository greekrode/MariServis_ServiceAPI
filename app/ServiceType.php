<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="servicetype",
 *   @SWG\Property(
 *       property="id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="service_id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="nama",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="biaya",
 *       type="decimal"
 *   ),
 *   @SWG\Property(
 *       property="department_id",
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
class ServiceType extends Model
{
    protected $fillable = [
      'nama',
      'biaya',
      'department_id'
    ];

    protected $hidden = [

    ];

    public function department() {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function services() {
        return $this->belongsToMany("App\Service", "service_service_type");
    }
}
