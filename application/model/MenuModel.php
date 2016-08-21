<?php
namespace app\model;
use think\Request;

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
            $menu = self::get($map);
        } else {
            $rules = $routeInfo['rule'];
            $pid = 0;

            // 菜单列表为树状，需要先找出第一层结点，然后再找出下层结点
            foreach ($rules as $rule)
            {
                // 如果$rule为空，则返回首页
                if ($rule === '')
                {
                    $map = ['is_home' => 1];
                } else {
                    $map = ['url' => $rule, 'pid' => $pid];
                }
                $menu = self::get($map);
                $pid = $menu->id;
            }
        }
        
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

    public function fatherMenu()
    {
        return $this->hasOne('MenuModel', 'pid');
    }
}