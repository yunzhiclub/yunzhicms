<?php
namespace app\model;

class ContentTypeModel extends ModelModel
{
    private $MenuModel = null;                     // 对应的菜单模型
    private $FieldModels = null;

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

    /**
     * 当前菜单类型对应的所有的字段模型 1:n
     * @return lists FieldModel
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T12:18:22+0800
     */
    public function FieldModels()
    {
        if (null === $this->FieldModels) {
            $this->FieldModels = FieldModel::getListsByRelateTypeRelateValue('Content', $this->getData('name'));
        }

        return $this->FieldModels;
    }

    /**
     * 获取对应的menu
     * @param int  $menu_id 
     * @return  object menu
     * @author  gaoliming 
     */
    public function getMenu($menu_id)
    {
        return MenuModel::get($menu_id);
    }
}