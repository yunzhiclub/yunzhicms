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
    // 定义资源路由
    '__curd__'=>[
        // 指向index模块的blog控制器
        'admin'                         => 'Index',
        'admin/menutype'                => 'MenuType',      // 菜单类型管理
        'admin/menu'                    => 'Menu',          // 菜单管理
        'admin/contenttype'             => 'ContentType',   // 文章类型管理
        'admin/filter'                  => 'Filter',        // 过滤器管理
        // 'admin/category.content'        => 'Content',       // 原 文章类型中对文章进行查询,涉及到2级CURD
        'admin/system'                  => 'System',        // 系统管理
        'admin/component'               => 'Component',     // 组件管理
        'admin/block'                   => 'Block',         // 区块管理
        'admin/user'                    => 'User',          // 用户管理
        'admin/usergroup'               => 'UserGroup',     // 用户组管理
        'admin/theme'                   => 'Theme',         // 主题管理
        'admin/Template'                => 'Template',      // 模板管理
    ],
];
