<?php
namespace app\module\controller;
/**
 * 菜单
 */
class MenuController extends ModuleController
{
	protected $config = [
		'menu_type'=>['value' => 'main', 'title' => '菜单类型', 'description' => '菜单类型'],
		
		];
	protected $filter = [];

	public function fetchHtml($config, $filter)
	{
		return $this->fetch('module@Menu/fetchHtml');
	}
}