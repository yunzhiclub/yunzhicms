<?php
namespace app\admin\controller;

class MenuController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}