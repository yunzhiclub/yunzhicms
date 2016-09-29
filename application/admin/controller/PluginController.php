<?php
namespace app\admin\controller;
use app\model\PluginModel;
use app\model\PluginTypeModel;
use app\model\AccessMenuPluginModel;
use app\model\AccessUserGroupPluginModel;
use app\model\UserGroupModel;
use app\model\MenuModel; 
use app\model\PositionModel; 
use think\Request;
/**
 * 插件管理
 * @author huangshuaibin
 */
class PluginController extends AdminController
{
	public function indexAction()
	{
		$PluginModel = new PluginModel;

		//获取未删除的组件
		$PluginModels = $PluginModel->where('is_delete', '=', '0')->paginate();
		$this->assign('PluginModels', $PluginModels);
		return $this->fetch();
	}

	public function editAction($id)
	{
		//将当前插件传入
		$PluginModel = PluginModel::get($id);
		$this->assign('PluginModel', $PluginModel);

		//插件类型传入
		$PluginTypeModels = PluginTypeModel::all();
		$this->assign('PluginTypeModels', $PluginTypeModels);

		//用户组信息传入
		$UserGroupModels = UserGroupModel::all();
		$this->assign('UserGroupModels', $UserGroupModels);

		//位置信息传入
		$PositionModel = new PositionModel;
		$map = array('type' => 'plugin');
		$PositionModels = $PositionModel->where($map)->select();
		$this->assign('PositionModels', $PositionModels);

		//获取伪树状二维数组列表
		$MenuModels = MenuModel::getTreeList(0, 2);
        $this->assign('MenuModels', $MenuModels);
        
		return $this->fetch();
	}

	public function updateAction($id)
	{
		$param = Request::instance()->param();

		//取出当前插件，保存数据
		$PluginModel = PluginModel::get($id);

		$PluginModel->setData('title', $param['title']);
		$PluginModel->setData('plugin_type_name', $param['plugin_type_name']);
		$PluginModel->setData('description', $param['description']);
		$PluginModel->setData('position_name', $param['position_name']);
		$PluginModel->setData('status', $param['status']);
		$PluginModel->setData('weight', $param['weight']);

		//保存配置信息
		if (array_key_exists('config', $param)) {
			$PluginModel->setData('config', json_encode($param['config']));
		}

		//保存过滤器信息
		if (array_key_exists('filter', $param)) {
			$PluginModel->setData('filter', json_encode($param['filter']));
		}

		$PluginModel->save();

		//更新 插件-菜单 关联表
		$AccessMenuPluginModel = new AccessMenuPluginModel;
		$map = array('plugin_id' => $id);
		$AccessMenuPluginModel->where($map)->delete();
	
		$datas = array();
		if (array_key_exists('menuids', $param)) {
			foreach ($param['menuids'] as $key => $value) {
				array_push($datas, ['plugin_id' => $id, 'menu_id' =>$key]);
			}
			$AccessMenuPluginModel->saveAll($datas);
		}

		//更新 插件-用户组 关联表
		$AccessUserGroupPluginModel = new AccessUserGroupPluginModel;
		$map = ['plugin_id' => $id];
		$AccessUserGroupPluginModel->where($map)->delete();

		$datas = array();
		if (array_key_exists('usergroupname', $param)) {
			foreach ($param['usergroupname'] as $key => $value) {
				$data = array();
				$data['plugin_id'] = $id;
				$data['user_group_name'] = $key;
				array_push($datas, $data);
			}

			$AccessUserGroupPluginModel->saveAll($datas);
		}

		return $this->success('保存成功', url('index'));
	}

	public function createAction()
	{
		//将插件类型传入
		$PluginTypeModels = PluginTypeModel::all();
		$this->assign('PluginTypeModels', $PluginTypeModels);

		//将用户组信息传入
		$UserGroupModels = UserGroupModel::all();
		$this->assign('UserGroupModels', $UserGroupModels);

		//将菜单信息传入
		$MenuModels = MenuModel::all();
		$this->assign('MenuModels', $MenuModels);

		//取出type为plugin的position传入
		$PositionModel = new PositionModel;
		$map = array('type' => 'plugin');
		$PositionModels = $PositionModel->where($map)->select();
		$this->assign('PositionModels', $PositionModels);

		return $this->fetch();
	}

	public function saveAction()
	{
		$param = Request::instance()->param();

		//保存插件信息
		$PluginModel = new PluginModel;

		$PluginModel->setData('title', $param['title']);
		$PluginModel->setData('plugin_type_name', $param['plugin_type_name']);
		$PluginModel->setData('description', $param['description']);
		$PluginModel->setData('position_name', $param['position_name']);
		$PluginModel->setData('status', $param['status']);
		$PluginModel->setData('weight', $param['weight']);

		$PluginModel->save();

		//保存 菜单-插件 关联表信息
		$id = $PluginModel->getData('id');
		$AccessMenuPluginModel = new AccessMenuPluginModel;
		$datas = array();
		if (array_key_exists('menuids', $param)) {
			foreach ($param['menuids'] as $key => $value) {
				$data = array();
				$data['plugin_id'] = $id;
				$data['menu_id'] = $key;
				array_push($datas, $data);
			}
			$AccessMenuPluginModel->saveAll($datas);
		}

		//保存 用户组-插件 关联信息
		$AccessUserGroupPluginModel = new AccessUserGroupPluginModel;
		$datas = array();
		if (array_key_exists('usergroupname', $param)) {
			foreach ($param['usergroupname'] as $key => $value) {
				$data = array();
				$data['plugin_id'] = $id;
				$data['user_group_name'] = $key;
				array_push($datas, $data);
			}
			$AccessUserGroupPluginModel->saveAll($datas);
		}

		return $this->success('保存插件信息成功', url('index'));
	}

    public function deleteAction($id)
    {
    	$PluginModel = PluginModel::get($id);
    	$map = array('plugin_id' => $id);

    	//删除 插件-用户组关联 表
    	$AccessUserGroupPluginModel = new AccessUserGroupPluginModel;
    	$AccessUserGroupPluginModel->where($map)->delete();

    	//删除 插件-菜单 关联表
    	$AccessMenuPluginModel = new AccessMenuPluginModel;
    	$AccessMenuPluginModel->where($map)->delete();

    	//软删除插件
    	if ('' === $PluginModel->getData('id')) {
    		return $this->error('该插件不存在', url('index'));
    	}

    	$PluginModel->setData('is_delete', 1);
    	if (false === $PluginModel->save()) {
    		return $this->error('删除失败');
    	}

    	return $this->success('删除成功', url('index'));

    }
}