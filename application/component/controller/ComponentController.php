<?php
namespace app\component\controller;
use think\Controller;
use app\component\ComponentInterface;
use app\Model\MenuModel;
use think\Request;

class ComponentController extends Controller implements ComponentInterface
{
    protected $config = [];
    protected $currentMenuModel;                    // 当前菜单
    public function __construct($config = [], Request $request = null)
    {   
        // 获取用户当前菜单, 并将当前菜单的配置写入config
        $this->currentMenuModel = MenuModel::getCurrentMenu();
        $this->param = $this->currentMenuModel->param;

        // 取出name及value两个字段的信息
        if (is_array($this->param))
        {
            foreach ($this->param as $key => &$param)
            {
                if (array_key_exists($key, $this->config))
                {
                    if (is_array($param))
                    {
                        $this->config[$key] = array_merge($this->config[$key], $param);
                    } else {
                        $this->config[$key]['value'] = $param;
                    }
                }
            }
        }

        // 合并传入的配置信息
        if (is_array($config))
        {
            foreach ($config as $key => $value)
            {
                if (array_key_exists($key, $this->config))
                {
                    if (is_array($value))
                    {
                        $this->config[$key] = array_merge($this->config[$key], $value);
                    } else {
                        $this->config[$key]['value'] = $value;
                    }
                }
            }
        }

        // 在这进行权限的判断
        parent::__construct($request);
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