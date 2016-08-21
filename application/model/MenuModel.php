<?php
namespace app\model;
use think\Request;
use app\Common;

class MenuModel extends YunzhiModel
{
    /**
     * 获取用户当前访问的菜单
     * @return MenuModel 
     */
    static public function getCurrentMenu()
    {
        $routeInfo = Request::instance()->routeInfo();
        if (empty($routeInfo))
        {
            $map = ['is_home' => 1];
        } else {
            $rules = $routeInfo['rule'];
            $url = '';
            // 菜单列表为树状，需要先找出第一层结点，然后再找出下层结点
            foreach ($rules as $key => $rule)
            {
                if ($key)
                {
                    $url .= '/' . $rule;
                } else {
                    $url = $rule;
                }
            }
            $map = ['url' => $url];
        }
        $menu = self::get($map);
        return $menu;
    }

    /**
     * 获取某个菜单类型的所有的列表
     * 先转化为树状，先转化为列表，这样顺序输出后，就有了上下级的结构
     * @param  string $menuTypeName 菜单类型名
     * @return lists               
     * 
     */
    public function getListsByMenuTypeNamePid($menuTypeName, $pid)
    {
        $map = ['menu_type_name' => $menuTypeName, 'pid' => $pid];
        $MenuModels = $this->where($map)->order('weight desc')->select();
        return $MenuModels;
    }

    /**
     * 子菜单列表
     * @return [type] [description]
     */
    public function sonMenus()
    {
        return $this->hasMany('MenuModel', 'pid');
    }

    /**
     * 父菜单
     * @return MenuModel 
     */
    public function fatherMenu()
    {
        return $this->hasOne('MenuModel', 'pid');
    }

    /**
     * 菜单是否被激活
     * @return boolean 
     * todo: 多级菜单的激活判断
     */
    public function isActive()
    {
        $currentMenuModel = Common::toggleCurrentMenuModel();
        if ($this->id === $currentMenuModel->id)
        {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 当前菜单是否存在子菜单
     * @return boolean 
     */
    public function isHaveSon()
    {
        $menuModels = $this->sonMenuModels();
        if (empty($menuModels))
        {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * 当前菜单的子菜单
     * 以sonMenus的区别在于 此函数对菜单的状态进行了判断
     * @return lists 
     */
    public function sonMenuModels()
    {
        $map = ['pid' => $this->id, 'status'=>0];
        $menuModels = $this->where($map)->select();
        return $menuModels;
    }
}