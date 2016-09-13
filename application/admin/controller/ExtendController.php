<?php
namespace app\admin\controller;
use app\model\UserGroupModel;                           // 用户组
use app\model\BlockModel;                               // 区块
use app\model\MenuModel;                                // 菜单
use app\model\BlockTypeModel;                           // 区块类型
use app\model\PositionModel;                            // 位置
use app\model\AccessUserGroupBlockModel;                // 权限：用户组-区块
use app\model\AccessMenuBlockModel;                     // 权限：菜单-区块
use app\Common;                                         // 通用函数库
use app\model\ComponentModel;                           // 组件

class ExtendController extends AdminController
{
    public function indexAction()
    {
        // 将区块类型信息传入V层
        $BlockTypeModels = BlockTypeModel::all();
        $this->assign('BlockTypeModels', $BlockTypeModels);

        // 将组件信息传入V层
        $Components = ComponentModel::paginate();
        $this->assign('Components', $Components);

        return $this->fetch();
    }

    public function createAction()
    {
        return 'hello';
    }
}
