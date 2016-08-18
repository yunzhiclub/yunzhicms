<?php
namespace app\admin\controller;

class IndexController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}
