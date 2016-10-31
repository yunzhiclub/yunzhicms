<?php
namespace app\common\validate;

use think\Validate;		//验证类

/**
* 验证用户组
*/
class BlockValidate extends Validate
{
	protected $rule = [
		'title' => 'require|max:100',
	];
}