<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    'admin' => 'index',
    'admin/login' => 'Login/index',

    // 定义资源路由
    '__curd__'=>[
        // 指向index模块的blog控制器
        'admin/menutype'                => 'MenuType',
        'admin/menu'                    => 'menu',
        'admin/category'                => 'category',
        'admin/category.content'        => 'Content',
        'category.content'              => 'Content',
        'admin/system'                  => 'System',
        'admin/component'               => 'Component',
        'admin/block'                   => 'Block',
        'admin/user'                    => 'User',
        'admin/usergroup'               => 'UserGroup',
        'admin/Template'                => 'Template',
    ],
];
