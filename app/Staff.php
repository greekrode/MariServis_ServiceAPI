<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="staff",
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
 *       property="no_telp",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="alamat",
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
 *       property="department_id",
 *       type="integer",
 *       format="int32"
 *   ),
 * )
 */

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
      'nama','no_telp','alamat','department_id'
    ];

    protected $hidden = [
      'created_at','updated_at'
    ];

    public function department() {
        return $this->belongsTo("App\Department", "department_id");
    }

    public function services() {
        return $this->belongsToMany("App\Service", "service_staff");
    }
}
