<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @SWG\Definition(
 *   definition="user",
 *   @SWG\Property(
 *       property="id",
 *       type="integer",
 *       format="int32"
 *   ),
 *   @SWG\Property(
 *       property="path",
 *       type="string"
 *   ),
 *   @SWG\Property(
 *       property="user_id",
 *       type="integer",
 *       format="int32"
 *   )
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
class UserImage extends Model
{

    protected $fillable = [
        'path','user_id'
    ];

    public function userimage() {
        return $this->belongsTo("App\User", "user_id");
    }
}
