<?php
namespace app\model;
use app\Common;
use think\File;
/**
 * json字段
 */
class FieldDataJsonModel extends FieldModel 
{
    /**
     * 字段过滤器
     * @param    为了与父类的函数格式保持一致
     * @return     array                   过滤后的信息
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T10:49:51+0800
     */
    public function filter($value = null)
    {
        $result = json_decode($this->getData('value'), true);
        if (null === $result) {
            $result = [];
        }

        return $result;
    }

    /**
     * 有则更新，无则新增
     * @param    string                   $fieldId fk fieldModel
     * @param    string                   $keyId   关键字信息
     * @param    array                   $value   值
     * @return                               
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T10:49:10+0800
     */
    static public function updateList($fieldId, $keyId, $value)
    {
        $value = json_encode($value);
        $map = ['field_id' => $fieldId, 'key_id' => $keyId];
        $Object = self::get($map);
        if ('' === $Object->getData('key_id')) {
            $Object->setData('field_id', $fieldId);
            $Object->setData('key_id', $keyId);
        }

        $Object->setData('value', $value);
        return $Object->save();
    }
}