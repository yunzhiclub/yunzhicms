<?php
return [
    // 标题过滤
    'title' => [ 
        'type'      => 'String',
        'function'  => 'substr',
        'param'     => [
            'length'    =>  6,
            'etc'       =>  '..',
        ],
          
    ], 

    // 生成的链接
    'href' => [ 
      'type'        => 'System',
      'function'    => 'makeFrontpageContentUrl',
    ],    
];