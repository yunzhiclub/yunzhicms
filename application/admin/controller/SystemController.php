<?php
namespace app\admin\controller;

class SystemController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}