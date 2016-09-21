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
		'name'  => 'alphaDash',			//验证机读字段是不是纯英文或者数组
		// 'name'  => 'unique:user_group',
	];
}