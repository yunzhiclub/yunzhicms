<?php
namespace app\model;

class ContentTypeModel extends ModelModel
{
    private $MenuModel;                     // 对应的菜单模型
    protected $pk = 'name';

    public function getName()
    {
        return $this->name;
    }
}