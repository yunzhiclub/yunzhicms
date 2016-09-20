<?php
namespace app\common\validate;

use think\Validate;           //验证类

class MenuValidate extends Validate
{
	protected $rule = [
		'title' => 'require'
	];
}