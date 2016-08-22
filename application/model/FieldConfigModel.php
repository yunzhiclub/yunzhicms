<?php
namespace app\model;
use think\Db;
use think\Loader;
/**
 * 字段配置
 */
class FieldConfigModel extends YunzhiModel
{
    protected $Entity;      // 配置实体
    /**
     * 设置实体类型对应的关键字
     * 比如该字段配置为： 为文章类别（Category)中的news增加扩展字段(body)
     * 则:
     * entityType = Category
     * bundle = news
     * filedName = body
     * @param string $bundle 
     */
    public function setBundle($bundle)
    {
        $this->data['bundle'] = $bundle;
    }

    /**
     * 设置实体类型
     * 实体类型：文章、文章类别、菜单，都可以称为一个实体类型
     * @param string $entityType 实体类型
     */
    public function setEntityType($entityType)
    {
        $this->data['entity_type'] = $entityType;
    }

    public function setEntity($Entity)
    {   
        $this->Entity = $Entity;
    }

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\Exception $e) {

            // 查询当前实体是否配置了当前字段
            $map = [];
            $map['entity_type'] = $this->data['entity_type'];
            $map['bundle']      = $this->data['bundle'];
            $map['field_name'] = $name;
            $map['status'] = 0;
            $FieldConfigModel = self::get($map);
            if (null === $FieldConfigModel)
            {
                return '';
            }

            // 实例化字表信息详情表
            $table = 'app\field\\' . Loader::parseName('field_data_' . $name, 1) . 'Field';
            $Filed = new $table;

            // 返回该实体下的字段信息
            return $Filed->getResult($this->data['entity_type'], $this->Entity->id, $FieldConfigModel->getData('is_one'));
        }
    }
}