<?php
namespace app\admin\controller;
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型

class MenutypeController extends AdminController
{
    public function indexAction()
    {
        $MenuTypeModel = new MenuTypeModel;
        $map = array(
            'is_deleted' => 0
            );

        //设置分页
        $MenuTypeModels = $MenuTypeModel->where($map)->paginate(config('paginate.var_page'));
        $this->assign('MenuTypeModels', $MenuTypeModels);
        return $this->fetch();
    }

    public function readAction($id)
    {
        
        $name = $id;
        $MenuModelType = MenuTypeModel::get($name);
        $this->assign('MenuModelType', $MenuModelType);

        $MenuModel = new MenuModel;
        $MenuModels = $MenuModel->getListsByMenuTypeNamePid($name, 0, 0);
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch();
    }

    public function deleteAction($id)
    {
        $name = $id;
        if (null === $name) {
            
            return $this->error('未找到相关记录');
        }

        //取出菜单类型
        $map = array('name' => $name);
        $MenuTypeModel = MenuTypeModel::get($map);

        //判断里面是不是有菜单
        $MenuModel = new MenuModel;
        $MenuModels = $MenuModel->getListsByMenuTypeNamePid($name, 0, 0);
        
        if (!empty($MenuModels)) {
            
            return $this->error('含有下一级菜单不能删除');
        }

        $MenuTypeModel->setData('is_deleted', 1)->save();

        return $this->success('删除成功', url('@admin/menutype'));
    }

    public function createAction()
    {
        return $this->fetch();
    }

    public function saveAction()
    {
        $data = input('post.');
        $MenuTypeModel = new MenuTypeModel;
        $MenuTypeModel->setData('title', $data['title']);
        $MenuTypeModel->setData('name', $data['name']);
        $MenuTypeModel->setData('description', $data['description']);

        $MenuTypeModel->save();

        return $this->success('保存成功', url('@admin/menutype'));
    }

    /**
     *return
     *权重排序
     *author liuxi
     */
    public function weightAction()
    {
        $data['status'] = "ERROR";
        $data['message'] = "";

        //判断传过来的值是否为空
        $weight = isset($_POST['weight'])?$_POST['weight']:array();

        //判断是否为空数组
        if (!empty($weight)) {
            foreach ($weight as $menuId=>$value) {
                //执行更新
                $MenuModel = new MenuModel;
                $id = $MenuModel->updateMenuWeightById($menuId, $value);
                if (false === $id) {
                    $data['message'][] = $menuId;
                }
            }
        }

        //更新成功，返回
        if ("" === $data['message']) {
            $data['status'] = "SUCCESS";
            return $data;
        }
        //更新失败，返回
        $data['message'] = '排序失败-' . implode(',', $data['message']);
        return $data;
    }
}