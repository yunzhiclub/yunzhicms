<?php
namespace app\component\controller;
use think\Controller;
use app\component\ComponentInterface;           // 组件接口
use app\Model\ComponentModel;                   // 组件
use think\Request;

class ComponentController extends Controller implements ComponentInterface
{
    protected $config   = [];       // 配置信息
    protected $fileter  = [];       // 过滤器信息
    protected $Model    = null;     // 模型

    public function __construct(Request $request = null)
    {
        // 初始化
        $this->_init();

        // 获取配置及过滤器信息
        $this->config = $this->Model->getConfig();
        $this->filter = $this->Model->getFilter();

        parent::__construct($request);
        $this->assign('filter', $this->filter);         // 过滤器传入V层
    }

    protected function _init()
    {
        // 获取当前被调用的类的名称
        $name = $this->_getCalledClassName();
        $modelName = 'app\component\model\\' . $name . 'Model';
        $this->Model = new $modelName;
    }

    /**
     * 获取当前被用的组件名
     * @return string 
     */
    protected function _getCalledClassName()
    {
        return substr(get_called_class(), strlen('app\component\controller\\'), -strlen('Controller'));
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