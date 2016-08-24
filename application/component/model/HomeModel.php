<?php
namespace app\component\model;

class HomeModel extends ComponentModel
{
    protected $config = [
        'count'=>['description'=>'显示新闻的条数', 'type'=>'text', 'value'=>3],
        ];

    protected $filter = [
        'title' => ['type' => 'String', 'function' => 'substr', 'param'=>['length'=>6, 'etc' => '..']],
        'href'  => ['type' => 'System', 'function' => 'makeFrontpageContentUrl'],
    ];
}