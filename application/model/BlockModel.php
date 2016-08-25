<?php
namespace app\model;
use app\Common;

/**
 * 区块
 */
class BlockModel extends ModelModel
{
    public $config = null;     // 配置信息
    public $filter = null;     // 过滤器信息

    /**
     * 区域:模块 = n:1
     */
    public function ModuleModel()
    {
        return $this->hasOne('ModuleModel', 'name', 'module_name');
    }

    public function getConfig()
    {
        if (null === $this->config)
        {
            $this->config = array();
            $this->config = Common::configMerge($this->ModuleModel->config, $this->config);
        }

        return $this->config;
    }


    public function getFilter()
    {
        if (null === $this->filter)
        {
            $this->filter = array();
            $this->filter = Common::configMerge($this->ModuleModel->filter, $this->filter);
        }

        return $this->filter;
    }

    /**
     * 获取某个position下的所有 启用 的区载信息
     * @param  string $name position名称
     * @return lists       BlockModels
     */
    public function getActiveListsByPositionName($name)
    {
        $map = ['position_name' => $name, 'status' => '0'];
        $order = ['weight' => 'desc'];
        $BlockModels = $this->where($map)->order($order)->select();
        foreach ($BlockModels as $key => &$BlockModel)
        {
            // 去除没有权限显示的区块
            if (!$BlockModel->isShowInCurrentMenu())
            {
                unset($BlockModels[$key]);
            }
        }
        return $BlockModels;
    }


    /**
     * 判断当前BLOCK是否在 正在访问的当前菜单 中显示
     * @return boolean 
     */
    public function isShowInCurrentMenu()
    {
        // 取出当前菜单
        $currentMenuModel = MenuModel::getCurrentMenuModel();

        // 判断当前菜单是否拥有此block的显示权限
        $map = ['block_id'=>$this->id, 'menu_id' => $currentMenuModel->id];
        $BlockMenuModel = BlockMenuModel::get($map);
        if (null === $BlockMenuModel)
        {
            return false;
        } else {
            return true;
        }
    }

    public function checkIsShow(MenuModel &$MenuModel)
    {
        $map = [];
        $map['block_id']    = $this->data['id'];
        $map['menu_id']     = $MenuModel->getData('id');
        if (null === BlockMenuModel::get($map))
        {
            return false;
        } else {
            return true;
        }
    }
}