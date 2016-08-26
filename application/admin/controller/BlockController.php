<?php
namespace app\admin\controller;

use app\model\BlockModel;                           // 区块
use app\model\MenuModel;                            // 菜单
use app\model\BlockMenuModel;                       // 区块菜单

class BlockController extends AdminController
{
    public function indexAction()
    {
        $BlockModels = BlockModel::paginate();
        $this->assign('BlockModels', $BlockModels);

        return $this->fetch();
    }

    public function editAction($id)
    {
        $BlockModel = BlockModel::get($id);
        $this->assign('BlockModel', $BlockModel);

        $MenuModels = MenuModel::getTreeList(0, 2);
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch();
    }

    public function updateAction($id)
    {
        $param = input('param.');

        $BlockModel = BlockModel::get($id);
        $BlockModel->setData('title', $param['title']);
        $BlockModel->setData('module_name', $param['module_name']);
        $BlockModel->setData('description', $param['description']);
        $BlockModel->setData('position_name', $param['position_name']);
        $BlockModel->setData('status', $param['status']);
        $BlockModel->setData('weight', $param['weight']);
       
        if (array_key_exists('config', $param))
        {
            $BlockModel->setData('config', json_encode($param['config']));
        }

        if (array_key_exists('filter', $param))
        {
            $filter = Common::makeFliterArrayFromPostArray($param['filter']);
            $BlockModel->setData('filter', json_encode($filter));
        }
       
        $BlockModel->save();

        // 更新block-menu关联表
        $BlockMenuModel = new BlockMenuModel;
        $map = ['block_id' => $id];
        $BlockMenuModel->where($map)->delete();

        $datas = array();
        if (array_key_exists('menuids', $param))
        {
            foreach ($param['menuids'] as $key => $value) {
                array_push($datas, ['block_id' => $id, 'menu_id' => $key]);
            }
            $BlockMenuModel->saveAll($datas);
        }

        return $this->success('操作成功', url('@admin/block'));
    }
}
