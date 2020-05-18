<?php
/**
 * Created by PhpStorm.
 * User: zyiwt
 * Date: 2020/4/11 0011
 * Time: 17:22
 */

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function show(){
        echo 'asdads';
    }
}
