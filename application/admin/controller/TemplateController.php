<?php
namespace app\admin\controller;

class TemplateController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}