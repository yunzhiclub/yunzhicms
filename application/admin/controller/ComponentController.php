<?php
namespace app\admin\controller;
use app\Common;                         // 通用函数库
use app\model\ComponentModel;
use app\model\MenuModel;
class ComponentController extends AdminController
{
    public function indexAction()
    {
        $map = array('is_deleted' => 0);
        $ComponentModel = new ComponentModel;
        $Components = $ComponentModel->where($map)->paginate();
        $this->assign('Components', $Components);
        return $this->fetch();
    }

    /**
     * 读取配置信息
     */
    public function readAction($name)
    {
        // 根据传入name获取信息
        $ComponentModel = ComponentModel::get($name);
        // var_dump($Component);
        $this->assign('ComponentModel', $ComponentModel);

        return $this->fetch();
    }

    public function createAction()
    {
        return $this->fetch('Component/create');
    }

    public function editAction($name)
    {
        $ComponentModel = ComponentModel::get($name);
        $this->assign('ComponentModel', $ComponentModel);
        return $this->fetch();
    }

    public function saveAction()
    {
        $data = input('post.');
        
        //保存数据
        $ComponentModel = new ComponentModel;
        $ComponentModel->setData('title', $data['title']);
        $ComponentModel->setData('name', $data['name']);
        $ComponentModel->setData('description', $data['description']);
        $ComponentModel->setData('author', $data['author']);
        $ComponentModel->setData('version', $data['version']);

        //验证并保存数据
        if (false === $ComponentModel->validate(true)->save($data))
        {
            return $this->error($ComponentModel->getError());
        }

        return $this->success('保存成功', url('index'));

    }

    public function updateAction($name)
    {
        $data = input('post.');

        //存入信息
        $ComponentModel = ComponentModel::get($name);
        $ComponentModel->setData('title', $data['title']);
        $ComponentModel->setData('author', $data['author']);
        $ComponentModel->setData('description', $data['description']);
        $ComponentModel->setData('version', $data['version']);

        if (array_key_exists('config', $data))
        {
            $ComponentModel->setData('config', json_encode($data['config']));
        }
        //验证并更新信息
        array_shift($data);
        if (false === $ComponentModel->validate(true)->save($data))
        {
            return $this->error($ComponentModel->getError());
        }

        return $this->success('更新成功', url('index'));
    }

    public function deleteAction($name)
    {
        //获取删除的对象
        $ComponentModel = ComponentModel::get($name);

        // todo
        //判断是否有菜单

        //删除组件
        $ComponentModel->setData('is_deleted', 1)->save();

        return $this->success('删除成功', url('index'));
    }
}
