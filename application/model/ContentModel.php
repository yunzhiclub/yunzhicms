<?php
namespace app\model;

class ContentModel extends ModelModel
{
    public function ContentTypeModel()
    {
        return $this->hasOne('ContentTypeModel', 'name', 'content_type_name');
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
            $ContentTypeModel = $this->ContentTypeModel;

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
}