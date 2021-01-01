<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/8/27
 * Time: 11:08 上午
 */

namespace app\lib\exception;

use think\Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @var int 自定义的错误码
     */
    public $code;

    /**
     * @var int HTTP状态码
     */
    public $httpStatusCode;

    public function __construct($code = 0, $message = "", Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
