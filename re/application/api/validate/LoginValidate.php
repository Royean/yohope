<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 20:55
 */

namespace app\api\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'code' => 'require',
        'iv' => 'require',
        'encryptedData' => 'require',
        'nickName|昵称' => 'require',
        'avatarUrl|头像' => 'require',
        'gender|性别' => 'require'
    ];
}
