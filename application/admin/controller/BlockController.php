<?php
namespace app\admin\controller;
use app\model\UserGroupModel;
use app\model\BlockModel;                               // 区块
use app\model\MenuModel;                                // 菜单
use app\model\AccessMenuBlockModel;                     // 权限：菜单-区块

class BlockController extends AdminController
{
    public function indexAction()
    {
        $BlockModel = new BlockModel;
        $BlockModels = $BlockModel->where('is_delete', '=', '0')->paginate();
        $this->assign('BlockModels', $BlockModels);

        return $this->fetch();
    }

    public function editAction($id)
    {
        $BlockModel = BlockModel::get($id);
        $this->assign('BlockModel', $BlockModel);

        $UserGroupModel = new UserGroupModel;
        $UserGroupModel = $UserGroupModel::all();
        $this->assign('UserGroupModel', $UserGroupModel);

        $MenuModels = MenuModel::getTreeList(0, 2);
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch();
    }

    public function updateAction($id)
    {
        $param = input('param.');

        $BlockModel = BlockModel::get($id);
        $BlockModel->setData('title', $param['title']);
        $BlockModel->setData('block_type_name', $param['block_type_name']);
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
        $AccessMenuBlockModel = new AccessMenuBlockModel;
        $map = ['block_id' => $id];
        $AccessMenuBlockModel->where($map)->delete();

        $datas = array();
        if (array_key_exists('menuids', $param))
        {
            foreach ($param['menuids'] as $key => $value) {
                array_push($datas, ['block_id' => $id, 'menu_id' => $key]);
            }
            $AccessMenuBlockModel->saveAll($datas);
        }

        return $this->success('操作成功', url('@admin/block'));
    }
    /**
    * 删除区块方法
    * @param  int $id 区块id
    * @return viod
    */
    public function deleteAction($id)
    {
        $BlockModel = BlockModel::get($id);
        if (false === $BlockModel) {
            return $this->error('删除失败:区块不存在' . $BlockModel->getError());
        }
        $BlockModel->setData('is_delete', 1);
        if (false === $BlockModel->save()) {
            return $this->error('删除失败');
        }

        return $this->success('删除成功', url('@admin/block'));
    }
}
