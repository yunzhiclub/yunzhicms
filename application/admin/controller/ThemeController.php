<?php
namespace app\admin\controller;
use app\model\ThemeModel;
/**
 * 主题管理
 */
class ThemeController extends AdminController
{
    public function indexAction()
    {
    	$ThemeModel = new ThemeModel;
    	$themesModel = $ThemeModel::All();
    	$this->assign('themesModel', $themesModel);
    	return $this->fetch();

        var_dump(get_called_class());
    }
    /**
     * 启用主题
     * @param  string $id 数据表中name字段
     * @return boolean     
     */
    public function readAction($id)
    {
    	$ThemeModel = new ThemeModel;
    	//调用 启用当前模板  方法
    	$ThemeModel->enable($id);
    	
    	return $this->success('启用成功', url('@admin/Theme/'));

    }

}