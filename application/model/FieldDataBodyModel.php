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
            $this->token = Common::makeTokenByMCA('field', 'Body', 'upload');
        }

        return $this->token;
    }
}

