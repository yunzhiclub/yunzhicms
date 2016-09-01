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

    public function ContentTypeModel()
    {
        if (null === $this->ContentTypeModel) {
            $map = ['name' => $this->getData('content_type_name')];
            $this->ContentTypeModel = ContentTypeModel::get($map);
        }

        return $this->ContentTypeModel;
    }

    /**
     * 重写__get， 取出扩展的字段值
     * @param  string $name 
     * @return        
     */
    public function __get($name)
    {
        // 取字段信息
        if ('_field' === $name)
        {
            // 获取新闻所在的类别
            $ContentTypeModel = $this->ContentTypeModel();
            
            // 初始化字段配置模型
            $FieldConfigModel = new FieldConfigModel();
            // 设置实体 用以查找扩展字段的值
            $FieldConfigModel->setObject($this);
            // 设置实体类别
            $FieldConfigModel->setType($this->name);
            // 设置实体名
            $FieldConfigModel->setValue($ContentTypeModel->getData('name'));

            return $FieldConfigModel;
        } else {
            return parent::__get($name);
        }
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