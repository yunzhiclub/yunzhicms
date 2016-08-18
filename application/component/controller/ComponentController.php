<?php
namespace app\component\controller;
use think\controller\Rest;
use app\component\ComponentInterface;
use app\Model\MenuModel;

class ComponentController extends Rest implements ComponentInterface
{
    protected $config = [];
    public function __construct($config = [])
    {   
        // 获取用户当前菜单, 并将当前菜单的配置写入config
        $MenuModel = MenuModel::getCurrentMenu();
        $this->config = $MenuModel->param;
        if (is_array($config))
        {
            $this->config = array_merge($this->config, $config);
        }

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