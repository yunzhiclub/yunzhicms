<?php
namespace app\admin\controller;
use app\model\ThemeModel;
use think\Request;                  // 初始化
/**
 * 主题管理
 */
class ThemeController extends AdminController
{
    /**
     * 主题管理index
     * @author huangshuaibin
     * @return bool 
     */
    public function indexAction()
    {
        $ThemeModel = new ThemeModel;

        //获取未删除的组件
        $ThemeModels = $ThemeModel->paginate();
    	$this->assign('ThemeModels', $ThemeModels);
    	return $this->fetch();
    }
    /**
     * 启用主题
     * @param  string $id 数据表中name字段
     * @author huangshuaibin
     * @return boolean
     */
    public function readAction()
    {
        $name = Request::instance()->param('name');
    	//调用 启用当前模板  静态方法
    	ThemeModel::setDefaultTheme($name);

    	return $this->success('启用成功', url('index'));
    }

}
