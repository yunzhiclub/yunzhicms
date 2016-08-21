<?php
namespace app\component\controller;
use think\Controller;
use app\component\ComponentInterface;           // 组件接口
use app\Model\MenuModel;                        // 菜单
use app\Model\ComponentModel;                   // 组件
use think\Request;
use app\Common;                                 // 通用接口

class ComponentController extends Controller implements ComponentInterface
{
    protected $config = [];                         // 默认配置信息
    protected $filter = [];                         // 默认过滤器信息
    protected $currentMenuModel;                    // 当前菜单
    public function __construct(Request $request = null)
    {   
        // 初始化配置信息 
        $this->_initConfig();           

        // 初始化过滤器信息
        $this->_initFilter();
        // 在这进行权限的判断
        //todo 
        
        // 调用父类的构造函数
        parent::__construct($request);
        // 送过滤器信息到V层
        $this->assign('filter', $this->filter);
    }

    /**
     * 初始化配置信息   
     */
    protected function _initConfig()
    {
        // 获取用户当前菜单, 并将当前菜单的配置写入config
        $this->currentMenuModel = MenuModel::getCurrentMenu();
        Common::toggleCurrentMenuModel($this->currentMenuModel);

        // 获取当前组件配置信息
        // $this->currentComponent = ComponentModel::getCurrentComponent(get_called_class());

        // 合并配置信息
        $this->config = Common::configMerge($this->config, $this->currentMenuModel->config);
        $this->filter = Common::configMerge($this->filter, $this->currentMenuModel->filter);
    }

    /**
     * 初始化过滤器
     */
    protected function _initFilter()
    {

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