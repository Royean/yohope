<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 2019/11/21
 * Time: 08:40
 */

namespace app\api\behavior;

class CORS
{
    public function run()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        if (request()->isOptions()) {
            exit();
        }
    }
}