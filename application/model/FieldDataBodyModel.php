<?php
namespace app\model;
use app\Common;
/**
 * body字段
 */
class FieldDataBodyModel extends FieldModel
{
    /**
     * 更新字段
     * @param    int                   $fieldId 字段ID
     * @param    int                   $keyId   
     * @param    string                   $value   值
     * @return   int                            更新的结果
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T15:26:18+0800
     */
    static public function updateList($fieldId, $keyId, $value)
    {
        $Object = self::get(['field_id' => $fieldId, 'key_id' => $keyId]);
        $Object->setData('value', $value);
        return $Object->save();
    }
}

