<?php
namespace app\component\controller;
use think\controller\Rest;
use app\component\ComponentInterface;
use think\Request;

class ComponentController extends Rest implements ComponentInterface
{
    protected $config = [];
    public function __construct($config = [])
    {   
        $routeInfo = Request::instance()->routeInfo();
        var_dump($routeInfo['rule'][0]);
        // 在这进行权限的判断
        parent::__construct();
    }
    public function indexAction()
    {

    }
    public function createAction()
    {

    }
    public function saveAction()
    {

    }
    public function readAction()
    {

    }
    public function editAction()
    {

    }
    public function updateAction()
    {

    }
    public function deleteAction()
    {

    }
}