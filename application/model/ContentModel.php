<?php
namespace app\model;

class ContentModel extends ModelModel
{
    private $ContentTypeModel       = null;             // 文章类型模型
    protected $preContentModel      = null;             // 上一篇文章
    protected $nextContentModel     = null;             // 下一篇文章

    protected $data = [
        'id'    => 0,
        'user_name' => '',
        'content_type_name' => '',
        'title'                 => '',
        'create_time'           => 0,
        'update_time'           => 0,
        'delete_time'           => 0,
        'is_freezed'            => 0,
        'weight'                => 0,
        'hit'                   => 0,
        'is_deleted'            => 0,
    ];

    /**
     * 内容类型 n:1
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T13:54:47+0800
     */
    public function ContentTypeModel()
    {
        if (null === $this->ContentTypeModel) {
            $map = ['name' => $this->getData('content_type_name')];
            $this->ContentTypeModel = ContentTypeModel::get($map);
        }

        return $this->ContentTypeModel;
    }


    /**
     * 通过扩展字段的 字段名 来获取字段内容
     * @param    string                   $fieldName 字段名
     * @return   Object                              FieldDataXXXModel 
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T14:13:25+0800
     */
    public function getFieldDataModelByFieldName($fieldName)
    {
        if (empty($fieldName)) {
            throw new \Exception("the param can't  empty", 1);
        }

        // 获取对应的全部字段的信息
        $FieldModels = $this->ContentTypeModel()->FieldModels();

        // 遍历当前 内容类型 的扩展字段信息.
        foreach ($FieldModels as $FieldModel) {
            // 找到当字段，则返回当前字段对应的扩展字段对象
            if ($FieldModel->getData('field_type_name') === $fieldName) {
                return $FieldModel->getFieldDataXXXModelByKeyId($this->getData('id'));
            }
        }

        throw new \Exception('not found fieldName:' . $fieldName . ' of ContentModel:' . $this->getData('id'), 1);
    }

    /**
     * 获取 上一篇 文章
     * @return 文章 ContentModel
     */
    public function getPreContentModel()
    {
        if (null === $this->preContentModel) {
            $map = [];
            $map['id'] = ['<', $this->getData('id')];
            $map['content_type_name'] = $this->getData('content_type_name');
            $this->preContentModel = $this->where($map)->order('id desc')->find(); 
        }
        return $this->preContentModel;
    }

    /**
     * 获取 下一篇 文章
     * @return 文章 ContentModel
     */
    public function getNextContentModel()
    {
        if (null === $this->nextContentModel) {
            $map = [];
            $map['id'] = ['>', $this->getData('id')];
            $map['content_type_name'] = $this->getData('content_type_name');
            $this->nextContentModel = $this->where($map)->order('id asc')->find();
        }
        return $this->nextContentModel;
    }
}