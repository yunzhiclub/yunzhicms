<?php
namespace app\module\controller;
use app\Common;
use app\model\MenuModel;
/**
 * 文字视频介绍
 */
class BreadCrumbController extends ModuleController
{
	protected $config = [];
	protected $filter = [];

	public function fetchHtml()
	{
		$currentMenuModel = Common::toggleCurrentMenuModel();
		
		

		$this->assign('currentMenuModel', $currentMenuModel);
		return $this->fetch('module@BreadCrumb/fetchHtml');
	}
}





// 将数组进行反转后，转化为可用的字符串
        //$linkPathArray = array_reverse($linkPathArray);