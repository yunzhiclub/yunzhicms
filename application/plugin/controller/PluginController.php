<?php
namespace app\plugin\controller;
use think\Controller;

use app\Common;                         // 通用

use app\model\PluginModel;              // 插件
use app\model\MenuModel;                // 菜单
use app\model\ThemeModel;               // 主题

/**
 * 插件管理
 */
class PluginController extends Controller
{
    private $PluginModel = null;            // 当前启用插件
    
    public function __construct(PluginModel $PluginModel, Request $request = null)
    {
        $this->PluginModel = $PluginModel;

        // 取配置过滤器信息
        $this->config = $PluginModel->getConfig();
        $this->filter = $PluginModel->getFilter();

        // 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();
        parent::__construct($request);

        // 获取当前主题信息
        $this->currentThemeModel = ThemeModel::getCurrentThemeModel();
        
        // 获取过滤器信息并传入V层
        $filterModels = $this->PluginModel->getFilterModels();
        $this->assign('filterModels', $filterModels);

        // 送配置 过滤器至V层
        $this->assign('config', $this->config);
        $this->assign('filter', $this->filter);
    }

    /**
     * 初始化，供Cx中position标签调用
     * @param  string $name 位置名字
     * @param object $object 由V层传入的对象
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($name, $object = null)
    {
        // 找出所有在当前position下的block
        $PluginModel = new PluginModel;
        $pluginModels = $PluginModel->getActiveListsByPositionName($name);

        $resultHtml = '';
        
        // 依次进行渲染，拼接
        foreach ($pluginModels as $pluginModel)
        {
            $className = 'app\plugin\controller\\' . $pluginModel->plugin_type_name . 'Controller';
            try 
            {
               
                // 实例化类 并调用
                $class = new $className($pluginModel);
                $result = call_user_func_array([$class, 'fetchHtml'], [$object]); 
                if ($result)
                {
                    $resultHtml .= $result;
                }
            } catch(\Exception $e) {
                if (config('app_debug'))
                {
                    throw $e;
                }
            } 
        }

        // 返回拼接后的字符串
        echo $resultHtml;
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
            'plugin' . DS .
            Common::getControllerName(get_called_class()) . DS .
            'fetchHtml.html';
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
}