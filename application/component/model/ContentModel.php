<?php
namespace app\component\model;

class ContentModel extends ComponentModel
{
    protected $config = [
        'id' => ['title' => '文章', 'description' => '将选择的文章内容显示在组件中', 'type' => 'text', 'value' => '1'],
    ];
}