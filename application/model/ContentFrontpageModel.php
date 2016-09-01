<?php
namespace app\model;

class ContentFrontpageModel extends ModelModel
{
    protected $ContentModel;
    protected $pk = 'content_id';

    public function ContentModel()
    {
        if (null === $this->ContentModel) {
            $this->ContentModel = ContentModel::get(['id' => $this->getData('content_id')]);
        }
        return $this->ContentModel;
    }
}