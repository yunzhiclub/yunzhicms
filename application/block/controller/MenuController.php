<?php
namespace app\block\controller;
use app\model\MenuModel;                    // 菜单
use think\Cache;                            // 缓存
use think\Request;                          // 请求

use app\model\BlockModel;                   // 区块
/**
 * 菜单
 */
class MenuController extends BlockController
{
    protected $token;
	public function fetchHtml()
	{
        // 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();

        // 取当前菜单类型, 用于按类型生成目录tree
        $menuTypeName = $this->config['menu_type_name']['value'];
        $pid = 0;

        // 生成token并送入V层，用于编辑该区块
        $token = $this->BlockModel->makeToken('Menu', 'edit');
        $this->assign('token', $token);

        // 取当前菜单类型下可见的菜单列表
        $menuModels = MenuModel::getAvailableSonMenuModelsByPidMenuTypeName($pid, $menuTypeName);
        $this->assign('menuModels', $menuModels);
		return $this->fetch('block@Menu/fetchHtml');
	}

    /**
     * 编辑区块，用于apiController根据token进行动态调用
     * @param    array                    $param menuId:生成token的用户触发的菜单 action:生成token时用户触发的action
     * @return   html                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-08T18:41:54+0800
     */
    static public function edit($data = [])
    {
        // 检测KEY键是否传入
        if (!array_key_exists('id', $data)) {
            throw new \Exception("传入的参数有误", 1);
        }

        // 获取当前区块模型
        $BlockModel = BlockModel::get(['id' => $data['id']]);
        if ('' === $BlockModel->getData('id')) {
            throw new \Exception("未找到对应的区块模型", 1);
        }

        $Object = new self();
        $Object->assign('BlockModel', $BlockModel);
        return $Object->fetch();
    }
}