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
    
];