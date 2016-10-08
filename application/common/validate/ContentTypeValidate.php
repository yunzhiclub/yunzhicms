<?php
namespace app\common\validate;

use think\Validate;         //内置验证类

/**
 * 验证类
 */
class ContentTypeValidate extends Validate
{
    protected $rule = [
        'title'         => 'require',
        'menu_id'       => 'require|number',
        'name'          => 'require|alphaDash|max:100',
    ];
}