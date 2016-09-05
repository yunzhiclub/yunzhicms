<?php
namespace app\field\controller;
use app\Common;

class ImageController extends FieldController
{
    public function uploadAjaxAction()
    {
        return $this->ajaxReturn(['hello'=>'hello']);
    }

    public function makeToken()
    {
        return Common::makeTokenByMCA('field', 'Image', 'upload');
    }
}