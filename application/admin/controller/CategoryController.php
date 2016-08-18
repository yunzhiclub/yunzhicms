<?php
namespace app\admin\controller;

class CategoryController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}
