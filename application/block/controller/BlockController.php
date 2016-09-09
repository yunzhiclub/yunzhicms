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
    static private $instance            = null;

    protected $config                   = null;         // 配置信息
    protected $filter                   = null;         // 过滤器信息
    protected $BlockModel               = null;         // 区块模型
    protected $currentThemeModel        = null;         // 当前主题
    protected $requestController        = '';           // 请求控制器信息
    protected $token                    = null;         // token

    public function __construct()
    {
        // 取出当前主题信息，供模板渲染使用
        $this->currentThemeModel = ThemeModel::getCurrentThemeModel();
        parent::__construct();

        // 传入Common，供模板渲染输出区块css,js使用
        $this->assign('Common', new Common);
    }


    static public function instance(BlockModel $BlockModel)
    {
        // todo: 
        // new self() 不管是谁继承的我，实例化的时候，只实例化当前类。
        // new static() 如果现在是其它继承于我的类进行调用，实例化的为继承我的那个类
        $Object = new static();
        $Object->BlockModel = $BlockModel;

        // 取配置过滤器信息
        $Object->config = $BlockModel->getConfig();;
        $Object->filter = $BlockModel->getFilter();

        // 获取当前主题信息
        $Object->currentThemeModel = ThemeModel::getCurrentThemeModel();

        // 获取过滤器信息并传入V层
        $filterModels = $Object->BlockModel->getFilterModels();
        $Object->assign('filterModels', $filterModels);

        // 送配置 过滤器至V层
        $Object->assign('config', $Object->config);
        $Object->assign('filter', $Object->filter);

        return $Object;
    }
    /**
     * 初始化，供Cx中position标签调用
     * @param  string positionName 位置名字
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($positionName)
    {
        // 找出所有在当前position下的block
        $BlockModel = new BlockModel;
        $blockModels = $BlockModel->getActiveListsByPositionName($positionName);

        $resultHtml = '';
        
        // 依次进行渲染，拼接
        foreach ($blockModels as $blockModel)
        {
            $className = 'app\block\controller\\' . $blockModel->block_type_name . 'Controller';
            try 
            {
                // 实例化类 并调用
                $Object = call_user_func_array([$className, 'instance'], [$blockModel]); 
                $result = $Object->fetchHtml(); 
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
        $controller = Common::getControllerName(get_called_class());
        $action = debug_backtrace()[1]['function'];

        // 拼接主题模板信息
        $themeTemplate = APP_PATH . 
            'theme' . DS . 
            $this->currentThemeModel->getData('name') . DS .
            'block' . DS .
            $controller . DS .
            $action . '.html';

        // 路径格式化，如果文件不存在，则返回false
        $themeTemplate = realpath($themeTemplate);

        // 主题文件存在，则调用主题文件进行渲染
        if (false !== $themeTemplate)
        {   
            $template = $themeTemplate;

        // 不存在，则进行同模块VIEW规则渲染
        } else {
            $template = 'block@' . $controller . '/' . $action;
        }

        // 渲染模板(直接调用$this->fetch()将导致死循环)
        return parent::fetch($template);
    }
}