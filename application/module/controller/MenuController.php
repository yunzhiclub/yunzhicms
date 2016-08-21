<?php
namespace app\module\controller;
use app\model\MenuModel;            // 菜单
/**
 * 菜单
 */
class MenuController extends ModuleController
{
	protected $config = [
		'menu_type_name'=>['value' => 'main', 'title' => '菜单类型', 'description' => '菜单类型', 'type' => 'text'],
		'id' => ['value' => 'mu-menu', 'title' => '']
		];
	protected $filter = [];

	public function fetchHtml()
	{
        $map = ['menu_type_name' => $this->config['menu_type_name']['value']];
        $map['pid'] = 0;
        $menuModels = MenuModel::where($map)->select();
        $this->assign('menuModels', $menuModels);
		return $this->fetch('module@Menu/fetchHtml');
	}
}