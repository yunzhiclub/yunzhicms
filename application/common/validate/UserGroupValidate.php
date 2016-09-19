<?php
namespace app\common\validate;

use think\Validate;		//验证类

/**
* 验证用户组
*/
class UserGroupValidate extends Validate
{
	protected $rule = [
		'name'	=> 'require|max:100',
		'title' => 'require|max:100',
	];
}