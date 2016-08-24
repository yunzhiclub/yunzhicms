<?php
namespace app\component\controller;
use think\Controller;
use think\Request;                              // think请求内置类
use app\Common;                                 // 通用接口

use app\component\ComponentInterface;           // 组件接口

use app\Model\ComponentModel;                   // 组件
use app\Model\MenuModel;                        // 菜单模型


class ComponentController extends Controller implements ComponentInterface
{
    protected $config               = null;         // 配置信息
    protected $fileter              = null;         // 过滤器信息
    protected $Model                = null;         // 模型
    protected $currentMenuModel     = null;         // 当前菜单

    public function __construct(Request $request = null)
    {
        // 取组件对应的当前菜单。及组件的配置、过滤器信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();
        $this->config = $this->currentMenuModel->getConfig();
        $this->filter = $this->currentMenuModel->getFilter();

        parent::__construct();

        // 配置信息，过滤器信息送入V层
        $this->assign('config', $this->config);
        $this->assign('filter', $this->filter);
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

    public function readAction($id)
    {

    }

    public function editAction($id)
    {

    }

    public function updateAction()
    {

    }

    public function deleteAction($id)
    {

    }
}