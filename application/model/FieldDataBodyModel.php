<?php
namespace app\model;
use app\Common;
/**
 * body字段
 */
class FieldDataBodyModel extends FieldDataModel
{
    public function makeToken()
    {
        if (null === $this->token) {
            $this->token = Common::makeTokenByMCAData('field', 'Body', 'upload');
        }

        return $this->token;
    }

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

    public function filter()
    {
        $value = $this->getData('value');
        $filter = $this->FieldModel()->getFilter();
        if (null === $filter) {
            return $value;
        }
        $className = 'app\filter\server\\' . $filter['type'] . 'Server';
        return call_user_func_array([$className, $filter['function']], [$value, $filter['param']]);
    }
     
}

