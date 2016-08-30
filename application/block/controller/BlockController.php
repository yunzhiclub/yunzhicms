<?php
namespace app\block\controller;

use think\Controller;

use app\Common;
use app\model\BlockModel;                       // 区块 模型
use app\model\BlockMenuModel;                   // 区块-菜单 模型
use app\model\MenuModel;                        // 菜单模型
use app\model\ThemeModel;                       // 主题

class BlockController extends Controller
{
    protected $config                   = null;         // 配置信息
    protected $filter                   = null;         // 过滤器信息
    protected $currentMenuModel         = null;         // 当前菜单
    protected $currentThemeModel        = null;         // 当前主题
    protected $requestController        = '';           // 请求控制器信息

    public function __construct(BlockModel $BlockModel, Request $request = null)
    {

        // 取配置过滤器信息
        $this->config = $BlockModel->getConfig();;
        $this->filter = $BlockModel->getFilter();

        // 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();
        parent::__construct($request);

        // 获取当前主题信息
        $this->currentThemeModel = ThemeModel::getCurrentThemeModel();

        // 送配置 过滤器至V层
        $this->assign('config', $this->config);
        $this->assign('filter', $this->filter);
    }

    /**
     * 初始化，供Cx中position标签调用
     * @param  string $name 位置名字
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($name)
    {
        // 找出所有在当前position下的block
        $BlockModel = new BlockModel;
        $blockModels = $BlockModel->getActiveListsByPositionName($name);

        $resultHtml = '';
        
        // 依次进行渲染，拼接
        foreach ($blockModels as $blockModel)
        {
            $className = 'app\block\controller\\' . $blockModel->block_type_name . 'Controller';
            try 
            {
                // 实例化类 并调用
                $class = new $className($blockModel);
                $result = call_user_func([$class, 'fetchHtml']); 
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
            'block' . DS .
            Common::getControllerName(get_called_class()) . DS .
            'fetchHtml.html';

        // 主题文件存在，则调用主题文件进行渲染
        if (is_file($themeTemplate))
        {   
            $template = $themeTemplate;
        }

        // 获取当前主题
        return $this->view->fetch($template, $vars, $replace, $config);
    }
}