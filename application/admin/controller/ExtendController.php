<?php
namespace app\admin\controller;

class ExtendController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}