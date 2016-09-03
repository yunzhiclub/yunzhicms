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
            $map = [];
            $map['relate_type'] = 'Content';
            $map['relate_value'] = $this->getData('name');
            $order = 'weight desc';
            $FieldModel = new FieldModel;
            $this->FieldModels = $FieldModel->where($map)->order($order)->select();
            unset($FieldModel);
        }

        return $this->FieldModels;
    }
}