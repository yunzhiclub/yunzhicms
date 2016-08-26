<?php
namespace app\admin\controller;

class UserGroupController extends AdminController
{
    public function indexAction()
    {
        return $this->fetch();
    }
}