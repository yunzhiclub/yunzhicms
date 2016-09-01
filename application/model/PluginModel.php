<?php
namespace app\model;

use app\Common;

class PluginModel extends ModelModel
{
    public $config = null;     // 配置信息
    public $filter = null;     // 过滤器信息

    /**
     * 区域:插件 = n:1
     */
    public function PluginTypeModel()
    {
        return $this->hasOne('PluginTypeModel', 'name', 'plugin_type_name');
    }

    public function getConfig()
    {
        if (null === $this->config)
        {
            $this->config = array();
            $this->config = Common::configMerge($this->PluginTypeModel->config, $this->config);
        }

        return $this->config;
    }


    public function getFilter()
    {
        if (null === $this->filter)
        {
            $this->filter = array();
            $this->filter = Common::configMerge($this->PluginTypeModel->filter, $this->filter);
        }

        return $this->filter;
    }

    /**
     * 获取某个position下的所有 启用 的插件信息
     * @param  string $name position名称
     * @return lists       PluginModels
     */
    public function getActiveListsByPositionName($name)
    {
        $map = ['position_name' => $name, 'status' => '0'];
        $order = ['weight' => 'desc'];
        $PluginModels = $this->where($map)->order($order)->select();
        foreach ($PluginModels as $key => &$PluginModel)
        {
            // 去除没有权限显示的区块
            if (!$PluginModel->isShowInCurrentMenu())
            {
                unset($PluginModels[$key]);
            }
        }
        return $PluginModels;
    }


    /**
     * 判断当前BLOCK是否在 正在访问的当前菜单 中显示
     * @return boolean 
     */
    public function isShowInCurrentMenu()
    {
        // 取出当前菜单
        $currentMenuModel = MenuModel::getCurrentMenuModel();

        // 判断当前菜单是否拥有此plugin的显示权限
        $map = ['plugin_id'=>$this->id, 'menu_id' => $currentMenuModel->id];
        $AccessPluginMenuModel = AccessMenuPluginModel::get($map);
        if (null === $AccessPluginMenuModel)
        {
            return false;
        } else {
            return true;
        }
    }

    public function checkIsShow(MenuModel &$MenuModel)
    {
        $map = [];
        $map['plugin_id']    = $this->data['id'];
        $map['menu_id']     = $MenuModel->getData('id');
        if (null === AccessPluginMenuModel::get($map))
        {
            return false;
        } else {
            return true;
        }
    }
}