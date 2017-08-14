<?php
namespace app\component\controller;
/**
 * 登陆注销与个人信息管理组件
 */
class BlogController extends ComponentController
{
    public function indexAction()
    {
         return $this->fetch('component@Blog/index');
    }
}