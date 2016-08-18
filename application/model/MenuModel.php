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
        $rules = $routeInfo['rule'];
        $pid = 0;
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
        return $menu;
    }

    protected $type = [
        'param'     => 'json',  // 菜单配置参数
    ];
}