<?php
return [
    // 注意注册路由的顺序：由长到短！
    'edit' => [
        'title'         => '编辑',
        'description'   => '编辑',
        'value'         => ['/:id/edit', 'GET'],
    ],

    'read'  => [
        'title'         => '查看单条信息',
        'description'   => '',
        'value'         => ['/:id', 'GET']    
    ],



    'index' => [
        'title'         => '浏览列表',
        'description'   => '用户登陆前和登陆后的form表单显示',
        'value'         => ['', 'GET']        
    ],
];