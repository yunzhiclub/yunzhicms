<?php
namespace app\model;

use app\Common;                         // 通用功能

/**
 * 过滤器
 */
class FilterModel extends ModelModel
{

    public function getParam()
    {
        $param = [];
        if (array_key_exists('param', $this->data))
        {
            $param = json_decode($this->data['param'], true);
        }
        return $param;
    }
    /**
     * 通过数组的信息找出filter对象
     * array (size=3)
     * 'type' => string 'String' (length=6)
     * 'function' => string 'substr' (length=6)
     * 'param' => 
     *   array (size=2)
     *     'length' => int 30                   // 配置项1
     *     'etc' => string '..' (length=2)      // 配置项2
     * @param  array  $filter 
     * @return FilterModel
     */
    static public function getFilterModelByArray($filter = [])
    {
        $map = [];
        if (array_key_exists('type', $filter))
        {
            $map['type'] = $filter['type'];
        }

        if (array_key_exists('function', $filter))
        {
            $map['function'] = $filter['function'];
        }

        $FilterModel = self::get($map);

        // 合并param参数信息
        if (array_key_exists('param', $filter) && is_array($filter['param']))
        {
            $FilterModel->param = Common::configMerge($FilterModel->param, $filter['param']);
        }

        return $FilterModel;
    }

    public function filter($value)
    {
        $className = 'app\filter\server\\' . $this->data['type'] . 'Server';
        $result = call_user_func_array(array($className, $this->function), array($value, $this->getParam()));

        if (false === $result)
        {
            return $value;
        }

        return $result;
    }
}