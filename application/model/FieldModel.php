<?php
namespace app\model;
use think\Loader;
use app\label\controller\LabelController;

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
    public function getFieldDataXXXModelByKeyId($keyId)
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

            $this->getDataByKeyId = $FiledDataModel->get($map);
        }

        return $this->getDataByKeyId;
    }

    /**
     * 字段 : 字段类型 = n:1
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T09:07:36+0800
     */
    public function FieldTypeModel()
    {
        if (null === $this->FieldTypeModel)
        {
            $this->FieldTypeModel = FieldTypeModel::get(['name' => $this->getData('field_type_name')]);
        }
        
        return $this->FieldTypeModel;
    }

    /**
     * 渲染 传入模型的当前字段
     * @param    Object                   &$Model 任意调用当前字段的模型
     * @return   string 按字段的label类型 进行html 渲染后输出的 html代码
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T09:35:46+0800
     */
    public function render(&$XXXModel)
    {
        // 根据关键字得到字段的模型 支持id与name关键字
        if ($XXXModel->getData('id') !== '')
        {
            $keyId = $XXXModel->getData('id');
        } else {
            $keyId = $XXXModel->getData('name');
        }

        // 获取 扩展字段模型
        $FieldDataXXXModel = $this->getFieldDataXXXModelByKeyId($keyId);

        // 对扩展字段模型进行标签的渲染
        return LabelController::renderFieldDataModel($this->FieldTypeModel()->getData('label_type'), $FieldDataXXXModel);
    }
}