<?php
return [
    // 注意注册路由的顺序：由长到短！
    'login' => [
        'title'         => '登录',
        'description'   => '登录',
        'value'         => ['/login', 'POST']   
    ],

    'logout'    => [
        'title'         => '注销',
        'description'   => '用户点击用进行注销操作',
        'value'         => ['/logout', 'GET']    
    ],

    'index' => [
        'title'         => '浏览',
        'description'   => '用户登陆前和登陆后的form表单显示',
        'value'         => ['', 'GET']        
    ],
    
    'add' => [
        'title'         => '增加',
        'description'   => '增加新用户注册信息',
        'value'         => ['/add', 'GET']
    ],

    'edit' => [
        'title'         => '编辑',
        'description'   => '编辑用户信息',
        'value'         => ['/edit', 'GET']
    ],

    'update' => [
        'title'         => '保存',
        'description'   => '保存用户注册信息',
        'value'         => ['/update', 'POST']
    ],

    'save' => [
        'title'         => '新用户保存',
        'description'   => '保存新用户用户注册信息',
        'value'         => ['/save', 'POST']
    ],

];