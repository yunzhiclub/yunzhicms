<?php
namespace app\model;
use think\Db;
use think\Loader;
/**
 * 类型
 */
class FieldTypeModel extends ModelModel
{
    protected $Object;      // 实体。第一篇文章都称为一个特定的实体\对象。
    /**
     * 设置实体类型对应的关键字
     * 比如该字段配置为： 为文章类别（Category)中的news增加扩展字段(body)
     * 则:
     * type = Category
     * value = news
     * filedName = body
     * @param string $value 
     */
    public function setValue($value)
    {
        $this->data['value'] = $value;
    }

    /**
     * 设置实体类型
     * 实体类型：文章、文章类别、菜单，都可以称为一个实体类型
     * @param string $entityType 实体类型
     */
    public function setType($type)
    {
        $this->data['type'] = $type;
    }

    /**
     * 设置实体
     * 比如当前在读取文章时，当前的实体为文章
     * @param [type] $Entity [description]
     */
    public function setObject($Object)
    {   
        $this->Object = $Object;
    }

    public function __get($name)
    {
        $result = parent::__get($name);
        if ('' !== $result)
        {
            return $result;
        } else {
            // 查询当前实体是否配置了当前字段
            $map = [];
            $map['type']        = $this->data['type'];
            $map['value']       = $this->data['value'];
            $map['field_name']  = $name;
            $map['status']      = 0;
            $FieldConfigModel   = self::get($map);
            if ('' === $FieldConfigModel->getData('id'))
            {
                return '';
            }

            // 实例化字表信息详情表
            $table = 'app\field\model\\' . Loader::parseName('field_data_' . $name, 1) . 'Model';
            $FieldModel = new $table;

            // 返回该对象实体下的字段信息
            return $FieldModel->getResult($FieldConfigModel->getData('id'), $this->Object->getData('id'), $FieldConfigModel->getData('is_one'));
        }
    }

    /**
     * 读取相关配置文件后，得出配置信息
     * @return array 
     */
    public function getConfig()
    {
        if (null === $this->config) {
            $configFilePath = APP_PATH . 
                'block' . DS . 
                'config' . DS .
                $this->getData('name') . 'Config.php';
            $configFilePath = realpath($configFilePath);
            if (false === $configFilePath) {
                $this->config = [];
            } else {
                $this->config = include $configFilePath;
            }
        }

        return $this->config;
    }

    /**
     * 读取相关 过滤器配置 文件后，得出过滤器信息
     * @return array 
     */
    public function getFilter()
    {
        if (null === $this->filter) {
            $filterFilePath = APP_PATH . 
                'block' . DS . 
                'filter' . DS .
                $this->getData('name') . 'Filter.php';
            $filterFilePath = realpath($filterFilePath);
            if (false === $filterFilePath) {
                $this->filter = [];
            } else {
                $this->filter = include $filterFilePath;
            }
        }

        return $this->filter;
    }
}