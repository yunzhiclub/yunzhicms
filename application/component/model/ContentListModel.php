<?php
namespace app\component\model;
/**
 * 文章列表
 */
class ContentListModel extends ComponentModel
{
    protected $config = [
        'categoryName' => ['type' => 'text', 'title' => '文章类别', 'description' => '显示哪个类别的文章', 'value' => 'news'],
        'count' => ['type' => 'text', 'title' => '每页大小', 'description' => '每页显示多少篇文章', 'value' => '1'],
        'order' => ['type' => 'text', 'title' => '排序方式', 'description' => '数据字段的排序方式', 'value'=>'weight desc, id desc']
    ];

    protected $filter = [
        'title' => ['type' => 'String', 'function' => 'substr', 'param'=>['length'=>30, 'etc' => '..']],
        'href'  => ['type' => 'System', 'function' => 'makeCurrentMenuReadUrl'],
        'date'  => ['type' => 'date', 'function' => 'formart', 'param' => 'Y-m-d'],
    ];
}