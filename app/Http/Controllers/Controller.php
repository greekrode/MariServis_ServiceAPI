<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//Illuminate\Http\Request - it is not a trait but a CLASS

/**
 * @SWG\Swagger(
 *   basePath="",
 *   host="mariservis.app",
 *   schemes={"http"},
 *   @SWG\Info(
 *       version="1.0",
 *       title="Mari Servis API",
 *       @SWG\Contact(
 *           name="RODERICK HALIM",
 *           url="https://uph.edu"
 *       ),
 *   ),
 *   @SWG\Definition(
 *       definition="Error",
 *       required={"code","message"},
 *       @SWG\Property(
 *           property="code",
 *           type="integer",
 *           format="int32"
 *       ),
 *       @SWG\Property(
 *           property="message",
 *           type="string"
 *       )
 *   )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
