<?php
namespace app\model;

class ContentTypeModel extends ModelModel
{
    private $MenuModel = null;                     // 对应的菜单模型
    protected $pk = 'name';

    public function getName()
    {
        return $this->name;
    }

    public function MenuModel()
    {
        if (null === $this->MenuModel) {
            $this->MenuModel = MenuModel::get(['id' => $this->getData('menu_id')]);
        }
        return $this->MenuModel;
    }
}