<?php
namespace app\admin\controller;
use app\model\UserGroupModel;                           // 用户组
use app\model\BlockModel;                               // 区块
use app\model\MenuModel;                                // 菜单
use app\model\BlockTypeModel;                           // 区块类型
use app\model\PositionModel;                            // 位置
use app\model\AccessUserGroupBlockModel;                // 权限：用户组-区块
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

        $BlockTypeModels = BlockTypeModel::all();
        $this->assign('BlockTypeModels', $BlockTypeModels);
        //var_dump($BlockTypeModels);
        //die();

        //将用户组信息传入
        $UserGroupModels = UserGroupModel::all();
        $this->assign('UserGroupModels', $UserGroupModels);

        //将位置信息传入
        $map['type'] = "block";
        $PositionModels = PositionModel::get($map)->select();
        $this->assign('PositionModels', $PositionModels);

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

        //更新user_group_block表
        $AccessUserGroupBlockModel = new AccessUserGroupBlockModel;
        $map = ['block_id' => $id];
        $AccessUserGroupBlockModel->where($map)->delete();

        $AccessUserGroupBlockDatas = array();
        if (array_key_exists('usergroupname', $param))
        {
            foreach ($param['usergroupname'] as $key => $value) {
                array_push($AccessUserGroupBlockDatas, ['block_id' => $id, 'user_group_name' => $key]);
            }
            $AccessUserGroupBlockModel->saveAll($AccessUserGroupBlockDatas);
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

        // 删除block-menu关联表中已经删除的区块信息
        $AccessMenuBlockModel = new AccessMenuBlockModel;
        $map = ['block_id' => $id];
        $AccessMenuBlockModel->where($map)->delete();

        //删除usergroup-menu关联表中已经删除的区块信息
        $AccessUserGroupBlockModel = new AccessUserGroupBlockModel;
        $AccessUserGroupBlockModel->where($map)->delete();
        
        if (false === $BlockModel) {
            return $this->error('删除失败:区块不存在' . $BlockModel->getError());
        }
        $BlockModel->setData('is_delete', 1);
        if (false === $BlockModel->save()) {
            return $this->error('删除失败');
        }
        return $this->success('删除成功', url('@admin/block'));
    }

    public function createAction()
    {

        $BlockTypeModels = BlockTypeModel::all();
        $this->assign('BlockTypeModels', $BlockTypeModels);

        //将用户组信息传入
        $UserGroupModels = UserGroupModel::all();
        $this->assign('UserGroupModels', $UserGroupModels);

        $MenuModels = MenuModel::getTreeList(0, 2);
        $this->assign('MenuModels', $MenuModels);

        //取type为block的postion传入
        $PositionModel = new PositionModel;
        $map = array('type' => 'blcok');
        $Positions = $PositionModel->where($map)->select();
        $this->assign('Positions', $Positions);

        return $this->fetch();
    }

    public function saveAction()
    {
        $param = input('param.');

        //将Block的信息，保存到数据表
        $BlockModel = new BlockModel;
        $BlockModel->setData('title', $param['title']);
        $BlockModel->setData('block_type_name', $param['block_type_name']);
        $BlockModel->setData('description', $param['description']);
        $BlockModel->setData('position_name', $param['position_name']);
        $BlockModel->setData('status', $param['status']);
        $BlockModel->setData('weight', $param['weight']);

        $BlockModel->save();

        //直接将menu数据存入表
        $id = $BlockModel->id;

        $AccessMenuBlockModel = new AccessMenuBlockModel;
        // $map = ['block_id' => $id];
        // $AccessMenuBlockModel->where($map)->delete();

        //拼接menu_id block_id 存入其中间表
        if (array_key_exists('menuids', $param)) {
            $datas = array();
            foreach ($param['menuids'] as $key => $value) {
                array_push($datas, ['block_id' => $id, 'menu_id' => $key]);
            }
            $AccessMenuBlockModel->saveAll($datas);
        }

        $AccessUserGroupBlockModel = new AccessUserGroupBlockModel;
        
        //拼接user_group_name block_id 存入其中间表
        if (array_key_exists('usergroupname', $param)) {
            $datas = array();
            foreach ($param['usergroupname'] as $key => $value) {
                array_push($datas, ['user_group_name' => $key, 'block_id' => $id]);
            }
            $AccessUserGroupBlockModel->saveAll($datas);
        }
        
        return $this->success('添加成功', url('@admin/block'));
    }
}
