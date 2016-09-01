<?php
namespace app\model;

use app\Common;

class PluginModel extends ModelModel
{
    protected $config = null;               // 配置信息
    protected $filter = null;               // 过滤器信息
    protected $PluginTypeModel = null;      // 插件类型MODEL

    /**
     * 区域:插件 = n:1
     */
    public function PluginTypeModel()
    {
        if (null === $this->PluginTypeModel) {
            $this->PluginTypeModel = PluginTypeModel::get(['name' => $this->getData('plugin_type_name')]);
        }
        return $this->PluginTypeModel;
    }

    public function getConfigAttr()
    {
        return json_decode($this->getData('config'), true);
    }

    public function getFilterAttr()
    {
        return json_decode($this->getData('filter'), true);
    }

    /**
     * 获取合并后，可以供CV使用的配置信息   
     * @return array 
     */
    public function getConfig()
    {
        if (null === $this->config)
        {
            $this->config = Common::configMerge($this->PluginTypeModel()->getConfigAttr(), $this->getConfigAttr());
        }

        return $this->config;
    }

    /**
     * 获取合并后可以供前台使用的过滤器信息
     * @return array 
     */
    public function getFilter()
    {
        if (null === $this->filter)
        {
            $this->filter = Common::configMerge($this->PluginTypeModel()->getFilterAttr(), $this->getFilterAttr());
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
        if ('' === $AccessPluginMenuModel->getData('menu_id'))
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
        $AccessPluginMenuModel = AccessPluginMenuModel::get($map);
        if ('' === $AccessPluginMenuModel->getData('menu_id'))
        {
            return false;
        } else {
            return true;
        }
    }
}