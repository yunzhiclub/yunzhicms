<?php
namespace app\admin\controller;
use app\model\PluginModel;
use app\model\PluginTypeModel;
use app\model\AccessMenuPluginModel;
use app\model\UserGroupModel;
use app\model\MenuModel; 
use app\model\PositionModel; 
/**
 * 插件管理
 * @author huangshuaibin
 */
class PluginController extends AdminController
{
	public function indexAction()
	{
		$PluginModel = new PluginModel;
		$PluginModels = $PluginModel->where('is_delete', '=', '0')->paginate();
		$this->assign('PluginModels', $PluginModels);
		return $this->fetch();
	}
}