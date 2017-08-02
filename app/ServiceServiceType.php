<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="serviceservicetype",
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
 *       property="service_type_id",
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
class ServiceServiceType extends Model
{
    protected $table = 'service_service_types';

    protected $fillable = [
        'service_id','service_type_id'
    ];

    protected $hidden =[
        'created_at','updated_at'
    ];
}
