<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   definition="servicestaff",
 *   @SWG\Property(
 *       property="id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="staff_id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="service_id",
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
class ServiceStaff extends Model
{
    protected $table = 'service_staff';

    protected $fillable = [
        'staff_id','service_id'
    ];

    protected $hidden =[
      'created_at','updated_at'
    ];
}
