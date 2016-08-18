<?php
namespace app\admin\controller;

class ContentController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}
