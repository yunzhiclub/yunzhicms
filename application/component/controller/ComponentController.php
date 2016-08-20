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
        // 初始化配置信息 
        $this->initConfig($config);           

        // 初始化过滤器信息
        
        // 在这进行权限的判断
        //todo 
        
        // 调用父类的构造函数
        parent::__construct($request);
        // 送过滤器信息到V层
        $this->assign('filter', $this->filter);
    }

    /**
     * 初始化配置信息
     * @param  array $config 用户自定义配置
     * @return bool          
     */
    public function initConfig($config)
    {
        // 获取用户当前菜单, 并将当前菜单的配置写入config
        $this->currentMenuModel = MenuModel::getCurrentMenu();
        $this->param = $this->currentMenuModel->param;

        // 合并配置信息
        $this->config = $this->_configMerge($this->config, $this->param);
        $this->config = $this->_configMerge($this->config, $config);

        return true;
    }

    /**
     * 合并配置信息
     * 将配置2中的配置信息，合并到配置1中
     * 示例：
     * config1:
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string '显示新闻的条数' (length=21)
     *     'type' => string 'text' (length=4)
     *     'value' => int 3
     *****************************************************************
     * 第一种形式：只改变value值
     * config2:
     * array (size=1)
     * 'count' => int 2
     *
     * @return
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string '显示新闻的条数' (length=21)
     *     'type' => string 'text' (length=4)
     *     'value' => int 2
     *****************************************************************
     * 第二种形式：改变其它值
     * array (size=1)
     * 'count' => 
     *   array (size=2)
     *     'description' => string 'hello' (length=5)
     *     'value' => string '4' (length=1)
     *
     * @return
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string 'hello' (length=5)
     *     'type' => string 'text' (length=4)
     *     'value' => string '4' (length=1)
     ******************************************************************    
     * @author panjie
     */
    protected function _configMerge($config1, $config2)
    {
        if (is_array($config2))
        {
            foreach ($config2 as $key => &$config)
            {
                if (array_key_exists($key, $config1))
                {
                    if (is_array($config))
                    {
                        $config1[$key] = array_merge($config1[$key], $config);
                    } else {
                        $config1[$key]['value'] = $config;
                    }
                }
            }
        }
        return $config1;
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