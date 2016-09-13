<?php
namespace app\admin\controller;
use app\model\ThemeModel;
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
    	$themeModels = ThemeModel::All();
    	$this->assign('themeModels', $themeModels);
    	return $this->fetch();
    }
    /**
     * 启用主题
     * @param  string $id 数据表中name字段
     * @author huangshuaibin
     * @return boolean
     */
    public function readAction($id)
    {
    	//调用 启用当前模板  静态方法
    	ThemeModel::enable($id);

    	return $this->success('启用成功', url('@admin/theme')); 
    }

}
