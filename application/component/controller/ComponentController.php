<?php
namespace app\component\controller;
use think\Controller;
use think\Request;                              // think请求内置类
use app\Common;                                 // 通用接口

use app\component\ComponentInterface;           // 组件接口

use app\model\ComponentModel;                   // 组件
use app\model\MenuModel;                        // 菜单模型
use app\model\UserModel;                        // 用户
use app\model\ThemeModel;                       // 主题

class ComponentController extends Controller implements ComponentInterface
{
    protected $config                   = null;         // 配置信息
    protected $fileter                  = null;         // 过滤器信息
    protected $Model                    = null;         // 模型
    protected $currentMenuModel         = null;         // 当前菜单
    protected $currentFrontUserModel    = null;         // 当前前台登陆用户
    protected $Request                  = null;         // 请求信息
    protected $currentThemeModel        = null;         // 当前主题

    public function __construct(Request $request = null)
    {
        parent::__construct();

        // 取组件对应的当前菜单。及组件的配置、过滤器信息.
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();
        // 取当前登陆用户信息
        $this->currentFrontUserModel = UserModel::getCurrentFrontUserModel();
        // 获取当前主题信息
        $this->currentThemeModel = ThemeModel::getCurrentThemeModel();
        // 获取当前请求信息
        $this->Request = Request::instance();
        // 根据action，计算访问权限值index->list
        $action = $this->Request->action();
        switch ($action) {
            case 'index':
                $access = 16;
                break;

            case 'create':
            case 'save':
                $access = 8;
                break;

            case 'edit':
            case 'update':
                $access = 2;
                break;

            case 'read':
                $access = 2;
                break;


            case 'delete':
                $access = 1;
                break;
            default:
                $access = 0;
                break;
        }

        // 权限判断
        if (!$this->currentFrontUserModel->getUserGroupModel()->getAccessByLCURDValue($this->currentMenuModel, $access))
        {
            return $this->error('您无权限访问该页面或您访问的页面不存在. TODO:404页面', url('@/'));
        }
        
        // 取配置信息、过滤器信息
        $this->config = $this->currentMenuModel->getConfig();
        $this->filter = $this->currentMenuModel->getFilter();
        $this->filterModels = $this->currentMenuModel->getFilterModels();

        // 配置信息，过滤器信息送入V层
        $this->assign('config', $this->config);
        $this->assign('filterModels', $this->filterModels);

    }

    /**
     * 加载模板输出
     * @access protected
     * @param string    $template 模板文件名
     * @param array     $vars     模板输出变量
     * @param array     $replace     模板替换
     * @param array     $config     模板参数
     * @return mixed
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        // 拼接主题模板信息
        $themeTemplate = APP_PATH . 
            'theme' . DS . 
            $this->currentThemeModel->getData('name') . DS .
            'component' . DS .
            $this->Request->controller() . DS .
            $this->Request->action() .
            '.html';

        // 主题文件存在，则调用主题文件进行渲染
        if (is_file($themeTemplate))
        {   
            $template = $themeTemplate;
        }

        // 获取当前主题
        return $this->view->fetch($template, $vars, $replace, $config);
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