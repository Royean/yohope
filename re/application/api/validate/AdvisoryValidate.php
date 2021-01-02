<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 4:57 下午
 */

namespace app\api\validate;

use think\Validate;

class AdvisoryValidate extends Validate
{
    protected $rule = array(
        'name|姓名' => 'require',
        'phone|电话' => 'require|number',
        'email|邮箱' => 'email',
        'content|内容' => 'require',
    );
}
