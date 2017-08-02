<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="department",
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
class Department extends Model
{
    protected $fillable = [
      'nama'
    ];

    protected $hidden = [
      'created_at','updated_at'
    ];

    public function serviceTypes() {
        return $this->hasMany('App\ServiceType', "department_id");
    }

    public function staffs() {
        return $this->hasMany("App\Staff", "department_id");
    }
}
