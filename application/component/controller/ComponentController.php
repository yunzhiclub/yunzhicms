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

class ComponentController extends Controller
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

        // 根据路由表中的action值，查找权限表,做出权限判断
        if (!$this->currentFrontUserModel->UserGroupModel()->isAllowedByMenuModelAction($this->currentMenuModel, $action))
        {
            return $this->error('您无权限访问该页面或您访问的页面不存在. TODO:404页面', url('@/'));
        }

        // 传Common供前台使用
        $this->assign('Common', new Common);

        // 取配置信息、过滤器信息
        $this->config = $this->currentMenuModel->getConfig();
        $this->filter = $this->currentMenuModel->getFilter();
        $this->filterModels = $this->currentMenuModel->getFilterModels();

        // 配置信息，过滤器信息送入V层
        $this->assign('config', $this->config);
        $this->assign('filterModels', $this->filterModels);
    }

    /**
     * 重写 加载模板输出
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
        // 路径格式化，如果文件不存在，则返回false
        $themeTemplate = realpath($themeTemplate);
        
        // 主题文件存在，则调用主题文件进行渲染
        if (false !== $themeTemplate)
        {   
            $template = $themeTemplate;
        }

        // 获取当前主题
        return $this->view->fetch($template, $vars, $replace, $config);
    }

    public function indexAction()
    {
        var_dump(debug_backtrace()[0]);        
    }
    /**
     * [createAction description]
     * @Author   Panjie                   panjie@mengyunzhi.com
     * @DateTime 2016-09-02T09:15:50+0800
     * @return   [type]                   [description]
     */
    public function createAction()
    {
        var_dump(debug_backtrace()[0]);
    }

    /**
     * [saveAction description]
     * @return   [type]                   [description]
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T09:19:36+0800
     */
    public function saveAction()
    {
        var_dump(debug_backtrace()[0]);
    }

    public function readAction($id)
    {
        var_dump(debug_backtrace()[0]);
    }

    public function editAction($id)
    {
        var_dump(debug_backtrace()[0]);
    }

    public function updateAction($id)
    {
        var_dump(debug_backtrace()[0]);
    }

    public function deleteAction($id)
    {
        var_dump(debug_backtrace()[0]);
    }


}