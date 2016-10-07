<?php
return [
    'index' => [
        'title'         => '浏览',
        'description'   => '用户登陆前和登陆后的form表单显示',
        'value'         => ['', 'GET']        
    ],
    'edit' => [
        'title'         => '编辑',
        'description'   => '站点编辑对用户进行操作',
        'value'         => ['/:id/edit', 'GET']
    ],
    'frozen' => [
        'title'         => '冻结',
        'description'   => '站点编辑对用户进行操作',
        'value'         => ['/frozen', 'GET']
    ],
    'reset' => [
        'title'         => '重置密码',
        'description'   => '站点编辑对用户进行操作',
        'value'         => ['/:id/reset', 'GET']
    ],
    'update' => [
        'title'         => '保存',
        'description'   => '保存用户修改信息',
        'value'         => ['/:id/update', 'POST']
    ],
];
