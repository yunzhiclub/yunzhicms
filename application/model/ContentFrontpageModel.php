<?php
namespace app\model;

class ContentFrontpageModel extends YunzhiModel
{
    protected $pk = 'content_id';

    public function ContentModel()
    {
        return $this->hasOne('ContentModel', 'id', 'content_id');
    }
}