<?php
namespace app\admin\controller;

class ComponentController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}
