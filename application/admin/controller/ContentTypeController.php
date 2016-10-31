<?php
namespace app\admin\controller;
use app\model\ContentTypeModel;                // 类别
use app\model\ContentModel;                    //内容类型
use app\model\MenuModel;                       //菜单

class ContentTypeController extends AdminController
{
    public function indexAction()
    {
        //从配置信息中获取分页的信息
        $PageSize = config('paginate.var_page');

        $ContentTypeModel = new ContentTypeModel;
        $map = array('is_delete' => 0);

        $ContentTypeModels =$ContentTypeModel->where($map)->paginate($PageSize);
        $this->assign('ContentTypeModels', $ContentTypeModels);
        return $this->fetch('ContentType/index');
    }

    /**
     * 获取所有相应菜单类型下的文章
     * @param  string $name 
     * @return template 
     * @author  gaoliming 
     */
    public function readAction($name)
    {
        $ContentTypeModel = ContentTypeModel::get($name);
        $this->assign('ContentTypeModel', $ContentTypeModel);

        $ContentModel  = new ContentModel;
        $ContentModels = $ContentModel->getListsByContentTypeNamePname($name, 0);
        $this->assign('ContentModels', $ContentModels);

        return $this->fetch('ContentType/read');
    }

    /**
     * 删除内容类型
     * @param string $name 
     * @author gaoliming
     */
    public function deleteAction($name )
    {
        $ContentTypeModel = ContentTypeModel::get($name);

        //判断是否含有文章
        $ContentModel  = new ContentModel;
        $ContentModels = $ContentModel->getListsByContentTypeNamePname($name, 0);
        if (!empty($ContentModels)) {
            return $this->error('不能删除因为此类型里面含有文章');
        }
        //删除并保存
        $ContentTypeModel->setData('is_delete', 1)->save();
        return $this->success('删除成功', url('ContentType/index'));
    }

    /**
     * 编辑内容类型
     * @param string  $name 
     * @author gaoliming
     */
    public function editAction($name)
    {
        //当前内容类型
        $ContentTypeModel = ContentTypeModel::get($name);
        $this->assign('ContentTypeModel', $ContentTypeModel);

        //取出所有的菜单
        $map = array('is_delete' => 0);
        $MenuModel  = new MenuModel;
        $MenuModels = $MenuModel->where($map)->select();
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch('ContentType/edit');
    }

    /**
     * 更新信息
     * @param  string $name 
     * @return  tempalate 
     * @author gaoliming
     */
    public function updateAction()
    {
        $data = input('param.');
        $ContentTypeModel = new ContentTypeModel;
        $ContentTypeModel->setData('title', $data['title']);
        $ContentTypeModel->setData('menu_id', $data['menu_id']);
        $ContentTypeModel->setData('name', $data['name']);
        $ContentTypeModel->setData('weight', $data['weight']);
        $ContentTypeModel->setData('description', $data['description']);

        //验证并保存
        if (false === $ContentTypeModel->validate()->isUpdate()->save($data)) {
            return $this->error('更新失败,请检查所填的内容正确与完整');
        }
        return $this->success('更新成功', url('ContentType/index'));
    }

    /**
     * 增加内容类型
     * @return  template
     * @author  gaoliming 
     */
    public function createAction()
    {
        //取出所有的menu
        //取出所有的菜单
        $map = array('is_delete' => 0);
        $MenuModel  = new MenuModel;
        $MenuModels = $MenuModel->where($map)->select();
        $this->assign('MenuModels', $MenuModels);

        //返回模板
        return $this->fetch('ContentType/create');
    }

    /**
     * 保存信息
     * @return  template 
     * @author  gaoliming
     */
    public function saveAction()
    {
        $data = input('param.');
        $ContentTypeModel = new ContentTypeModel;
        $ContentTypeModel->setData('title', $data['title']);
        $ContentTypeModel->setData('menu_id', $data['menu_id']);
        $ContentTypeModel->setData('name', $data['name']);
        $ContentTypeModel->setData('weight', $data['weight']);
        $ContentTypeModel->setData('description', $data['description']);

        //验证并保存
        if (false === $ContentTypeModel->validate()->save($data)) {
            return $this->error("保存失败,请检查所填的内容正确与完整");
        }
        return $this->success('保存成功', url('ContentType/index'));
    }
}
