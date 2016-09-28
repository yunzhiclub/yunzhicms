<?php
return [
    // 标题
    'title' => [
        'type'      => 'String',
        'function'  => 'substr',
        'param'     => [
            'length'    => 30,
            'etc'       => '..',
        ],
    ],

    // 链接
    'href' => [
        'type'      => 'System',
        'function'  => 'makeCurrentMenuReadUrl',
    ],
    
    // 日期格式化
    'date' => [
        'type'      => 'date',
        'function'  => 'format',
        'param' => [
            'dateFormat'    => 'Y-m-d',
        ],
            
    ],
];