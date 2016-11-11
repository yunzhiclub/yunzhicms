<?php
return [
    'contentTypeName' => [
        'type'          =>  'text',
        'title'         =>  '文章类别',
        'description'   =>  '显示哪个类别的文章',
        'value'         =>  'news',
    ], 
      
    'count' => [
        'type'          => 'text',
        'title'         => '每页大小',
        'description'   => '每页显示多少篇文章',
        'value'         => '3',
    ],
    
    'order' => [
        'type'          =>  'text',
        'title'         =>  '排序方式',
        'description'   =>  '数据字段的排序方式',
        'value'         =>  'weight desc, id desc',
    ],
];