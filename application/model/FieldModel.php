<?php
namespace app\model;
use think\Loader;
use app\Common;
use app\field\controller\FieldController;

/**
 * 字段设置
 */
class FieldModel extends ModelModel
{
   

    protected $config       = null;             // 配置信息
    protected $filter       = null;             // 过滤器信息
    protected $token        = null;             // token
    protected $simpleConfig = null;             // 简单配置信息

    private $getDataByKeyId = null;
    private $getDataByKeyId_KeyId = null;
    private $FieldTypeModel = null;             // 字段类型模型
    private $FieldModel = null;

    /**
     * 供继承于此类的 子类 使用
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-19T09:03:50+0800
     */
    public function FieldModel()
    {
        if (null === $this->FieldModel) {
            if ('' === $this->getData('field_id')) {
                $this->FieldModel = FieldModel::get(['id' => $this->getData('id')]);
            } else {
                $this->FieldModel = FieldModel::get(['id' => $this->getData('field_id')]);
            }
        }
        return $this->FieldModel;
    }

    /**
     * 将驼峰式写法 改完 xx_x_型
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T10:52:07+0800
     */
    public function getParseName()
    {
        return Loader::parseName($this->name);
    }

    /**
     * 获取字段配置信息 
     * @return   array
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T09:45:37+0800
     */
    public function getConfigAttr()
    {
        return json_decode($this->getData('config'), true);
    }

    /**
     * 获取合并后，可以供CV使用的配置信息   
     * 供继承本类的XXXModel扩展字段使用
     * @return array 
     */
    public function getConfig()
    {
        
        if (null === $this->config) {
            // todo:获取 数据表配置信息
            
            // 获取 文件配置信息 进行覆盖
            $configName = substr($this->name, 9) ;

            // 拼接主题模板信息
            $configFilePath = APP_PATH . 
                'field' . DS . 
                'config' . DS .
                $configName . 'Config.php';
            // 路径格式化，如果文件不存在，则返回false
            $configFilePath = realpath($configFilePath);

            // 配置文件存在，则抓取
            if (false !== $configFilePath)
            {
                $this->config = include $configFilePath;
            } else {
                $this->config = [];
            }

            // todo:合并配置信息
            $this->config = Common::configMerge($this->config, $this->FieldModel()->getConfigAttr());
        }

        return $this->config;
    }

    /**
     * 获取 简单配置信息
     * @return   array                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T09:51:36+0800
     */
    public function getSimpleConfig()
    {
        if (null === $this->simpleConfig) {
            $this->simpleConfig = [];
            foreach ($this->getconfig() as $key => $config) {
                $this->simpleConfig[$key] = $config['value'];
            }
        }

        return $this->simpleConfig;
    }

    public function getFilter()
    {
        return json_decode($this->getData('filter'), true);
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

            // 实例化 字段信息详情表
            $table = 'app\model\\' . Loader::parseName('field_data_' . $this->getData('field_type_name'), 1) . 'Model';
            $FiledDataModel = new $table;

            $this->getDataByKeyId = $FiledDataModel->get($map);

            // 如果返回默认值，则将field_id, key_id传入。防止关联调用时数据不存在抛出的异常
            if ('' === $this->getDataByKeyId->getData('field_id'))
            {
                $this->getDataByKeyId->setData('field_id', $this->getData('id'));
                $this->getDataByKeyId->setData('key_id', $keyId);
            }
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
    public function render($action)
    {
        // 对扩展字段模型进行标签的渲染
        return FieldController::renderFieldDataModel($this, $action);
    }

    /**
     * 更新列表的值
     * @param    lists                   &$lists 
     * @param    string                   $keyId  更新的关键字
     * @return                              
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T10:38:41+0800
     */
    static public function updateLists(&$lists, $keyId)
    {
        foreach ($lists as $fieldId => $value) {
            try {
                $FieldModel = self::get(['id' => $fieldId]);
                $dataName = ucfirst($FieldModel->getData('field_type_name'));
                $className = 'app\model\FieldData' . $dataName . 'Model';
                call_user_func_array([$className, 'updateList'], [$fieldId, $keyId, $value]);
            } catch (\Exception $e){
                throw $e;
            }
        }
    }

    /**
     * 更新扩展字段
     * @param    int                   $fieldId 字段id
     * @param    int                   $keyId   关键字id
     * @param    |||                   $value   值
     * @return    更新的id值                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T15:21:43+0800
     */
    static public function updateList($fieldId, $keyId, $value)
    {
        var_dump('请重写'. get_called_class() . '::updateList. 该函数用于数据字段的更新');
    }

    /**
     * 获取关联的字段列表
     * @param    string                   $relateType  关系类型
     * @param    strint                   $relateValue  关系类型值
     * @return   lists FieldModels
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T09:07:34+0800
     */
    static public function getListsByRelateTypeRelateValue($relateType, $relateValue)
    {
        $map = ['relate_type' => $relateType, 'relate_value' => $relateValue];
        $order = 'weight desc';
        $Object = new static();
        return $Object->where($map)->order($order)->select();
    }

    /**
     * 字段过滤
     * @param    string                   $value 输入值
     * @return   string                          输出值
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T09:34:35+0800
     */
    public function filter($value = null)
    {   
        if (null === $value) {
            $value = $this->getData('value');
        }

        // 获取过滤器信息
        $filter = $this->FieldModel()->getFilter();

        if (null === $filter) {
            return $value;
        }

        if (isset($filter['type'])) {
            // 调用过滤器进行过滤
            $className = 'app\filter\server\\' . $filter['type'] . 'Server';
            if (isset($filter['param'])) {
                $param = $filter['param'];
            } else {
                $param = [];
            }

            return call_user_func_array([$className, $filter['function']], [$value, $param]);
        } else {
            return $value;
        }
    }

    
    /**
     * 生成前台可以直接调用的token
     * @param    string                   $action 
     * @return   string                           
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-08T09:47:07+0800
     */
    public function makeToken($action, $data = [])
    {
        $data = array_merge(['id' => $this->getData('id')], $data);
        // $token = Common::makeTokenByMCAData('filed', $this->FieldDataXXXXModel()->getData('name'), $action, $data);
        $controller = $this->FieldModel()->getData('field_type_name');
        $token = Common::makeTokenByMCAData('field', $controller, $action, $data);
        return $token;
    }

    /**  
     * 根据relate_value的取出相应的菜单  
     * @return  array   
     * @author  gaoliming   
    */  
   public function getallrelatetypefield($relate_type)  
    {  
        if (null === $relate_type) {  
            $FieldModels = $this->select();  
            } else {  
            $FieldModels = $this->where('relate_type', 'like', '%' . $relate_type . '%')->select();  
       }  
             
        $number      = count($FieldModels);  
        $map         = array($FieldModels['0']->relate_value);  
        for ($i=1; $i < $number; $i++) {   
            $j = 0;  
            foreach ($map as $value) {  
                if ($FieldModels[$i]->relate_value === $value) {  
                   break;  
                }  
               $j++;  
            }  
            if ($j === count($map)) {  
               array_push($map, $FieldModels[$i]->relate_value);  
            }  
        }  
        $FieldModelArray = array();  
        foreach ($map as $value) {  
            $data = array('relate_value' => $value);  
            array_push($FieldModelArray, $this->where($data)->find());  
        }  
 
        return $FieldModelArray;  
    }  
  
    /**  
     * 获取相应字段类型  
     * @return object  
     * @author gaoliming  
     */  
   public function getFieldTypebyfieldtypename()  
   {  
        //制定索引  
        $map = array('name' => $this->field_type_name);  
 
        $FieldTypeModel = new FieldTypeModel;  
        return $FieldTypeModel->where($map)->find();   
    }  


    /**
     * 字段排序
     * @return  bool 
     * @author  gaoliming 
     */
    public function updateFieldWeight($weight)
    {
        //判断数组是否是空数组
        if (!empty($weight)) {
            foreach ($weight as $key => $value) {
                $FieldModel = $this->get($key);
                if ($FieldModel->weight != $value) {
                    if (false === $FieldModel->setData('weight', $value)->save()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}