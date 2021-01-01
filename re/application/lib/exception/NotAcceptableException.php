<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/8/27
 * Time: 11:07 上午
 */

namespace app\lib\exception;

class NotAcceptableException extends BaseException
{
    public $httpStatusCode = 406;
}
