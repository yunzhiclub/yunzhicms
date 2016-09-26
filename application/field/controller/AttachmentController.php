<?php
namespace app\field\controller;

use app\Common;
use think\Request;

class AttachmentController extends FieldController
{
    public function index()
    {
        return parent::renderAction('index');
    }

    public function edit()
    {
        $this->assign('token', $this->FieldDataXXXModel->makeToken('upload'));
        return parent::renderAction('edit');
    }
}