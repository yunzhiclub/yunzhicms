<?php
namespace app\model;
use think\Loader;

/**
 * 字段设置
 */
class FieldModel extends ModelModel
{
   

    protected $config = null;           // 配置信息
    protected $filter = null;           // 过滤器信息


    private $getDataByKeyId = null;
    private $getDataByKeyId_KeyId = null;
    private $FieldTypeModel = null;             // 字段类型模型


    /**
     * 获取合并后，可以供CV使用的配置信息   
     * @return array 
     */
    public function getConfig()
    {
        if (null === $this->config)
        {
            $this->config = Common::configMerge($this->BlockTypeModel()->getConfig(), $this->getConfigAttr());
        }
        return $this->config;
    }

    /**
     * 获取合并后可以供前台使用的过滤器信息
     * @return array 
     */
    public function getFilter()
    {
        if (null === $this->filter)
        {
            $this->filter = Common::configMerge($this->BlockTypeModel()->getFilter(), $this->getFilterAttr());
        }

        return $this->filter;
    }

    /**
     * 通过 关键字值 获取数据对象信息
     * @param    int                   $keyId 关键字值
     * @return   lists | list                          FieldDataXXXXModel
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T13:37:08+0800
     */
    public function getDataByKeyId($keyId)
    {
        if ($keyId !== $this->getDataByKeyId_KeyId)
        {
            $this->getDataByKeyId_KeyId = $keyId;
            $map                = [];
            $map['field_id']    = $this->getData('id');
            $map['key_id']      = $keyId;
            $map['is_deleted']  = 0;

            // 实例化 字段信息详情表
            $table = 'app\field\model\\' . Loader::parseName('field_data_' . $this->getData('field_type_name'), 1) . 'Model';
            $FiledDataModel = new $table;

            if ($this->getData('is_one')) {
                $this->getDataByKeyId = $FiledDataModel->get($map);
            } else {
                $this->getDataByKeyId = $FiledDataModel->where($map)->order('weight desc')->select();
            }
        }

        return $this->getDataByKeyId;
    }

    public function FieldTypeModel()
    {
        if (null === $this->FieldTypeModel)
        {
            $this->FieldTypeModel = FieldTypeModel::get(['name' => $this->getData('field_type_name')]);
        }
        
        return $this->FieldTypeModel;
    }
}