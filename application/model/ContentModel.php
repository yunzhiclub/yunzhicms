<?php
namespace app\model;

class ContentModel extends ModelModel
{
    public function CategoryModel()
    {
        return $this->hasOne('CategoryModel', 'name', 'category_name');
    }

    /**
     * 将模型做为参数传入后，竟然可以直接输出保护类型的变量了，这点另人费解.
     * TODO:找规律、查资料，弄清楚为什么将类传入后，直接输出了保护类型的变量。
     * @param  [type] &$CategoryModel [description]
     * @return [type]                 [description]
     */
    public function test(&$CategoryModel)
    {
        var_dump($CategoryModel);

        // 获取新闻所在的类别
        var_dump($CategoryModel->name);
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
            $CategoryModel = $this->CategoryModel;

            // 初始化字段配置模型
            $FieldConfigModel = new FieldConfigModel();
            // 设置实体 用以查找扩展字段的值
            $FieldConfigModel->setEntity($CategoryModel);
            // 设置实体类别
            $FieldConfigModel->setEntityType($this->name);
            // 设置实体名
            $FieldConfigModel->setBundle($CategoryModel->getData('name'));

            return $FieldConfigModel;
        } else {
            return parent::__get($name);
        }
    }
}