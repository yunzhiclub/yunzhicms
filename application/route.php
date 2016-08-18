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
    '__rest__'=>[
        // 指向index模块的blog控制器
        'admin/menu'=> 'Menu',
        'admin/category' => 'Category',
        'admin/content'  => 'Content',
        'admin/system'      => 'System',
        'admin/component'   => 'Component',
        'admin/block'       => 'Block',
    ],
];
