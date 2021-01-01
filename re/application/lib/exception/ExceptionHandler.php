<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/8/27
 * Time: 11:07 上午
 */

namespace app\lib\exception;

use think\Env;
use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) { // 如果是自定义的异常
            $code = $e->code;
            // 如果自定义错误异常，则返回自定义的错误异常
            if (!empty($e->getMessage())) {
                $message = $e->getMessage();
            } else {
                $message = config('error_code.' . $e->code);
            }
            $httpStatusCode = $e->httpStatusCode;
        } else { # 系统异常
            if (Env::get('app.debug', false)) { # 如果开启了调试，则走正常异常
                return parent::render($e);
            }

            # 没开调试，则覆盖异常，不让用户看到完整的错误信息
            $code = 9999;
            $message = '服务器内部错误';
            $httpStatusCode = 500;
            $this->recordErrorLog($e);
        }

        # 异常返回数据
        $result = [
            'code' => $code,
            'msg' => $message,
            'data' => array(
                'request_url' => Request::instance()->url()
            ),
            'time' => time()
        ];
        return json($result, $httpStatusCode);
    }

    # 记录日志
    private function recordErrorLog(Exception $exception)
    {
        $data = [
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
        ];
        $log = "[{$data['code']}]{$data['message']}";

        Log::record($log, 'error');
        return true;
    }
}
