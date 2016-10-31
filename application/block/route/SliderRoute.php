<?php
return [
    // 在这，给出的是区块的action类型及说明，用于权限的更新与判断。
    // 由于并不是真正的路由，所以不会添加到路由表中
    'edit' => [
        'title'         => '编辑',
        'description'   => '编辑',
        'action'        => 'edit',  
    ],

    'save'  => [
        'title'         => '保存',
        'description'   => '保存用于数据的更新',
        'action'        => 'save',
    ],
];