<?php
namespace app\field\controller;

use think\Controller;
use app\Common;
use think\Loader;
use think\Request;

use app\model\ThemeModel;                           // 主题
use app\model\AccessUserGroupFieldModel;            // 用户组字段权限

class FieldController extends Controller
{
    protected $FieldDataXXXModel = null;                    // 某个扩展字段的模型
    protected $FieldModel;                                  // 字段模型
    private $nameTag;                                       // 字段输出时的 name 标签
    private $token;                                         // token
    protected $config;                                      // 配置信息
    protected $currentThemeModel        = null;         // 当前主题

    public function __construct()
    {
        // 取出当前主题信息，供模板渲染使用
        $this->currentThemeModel = ThemeModel::getCurrentThemeModel();
        parent::__construct();
    }

    /**
     * 正式渲染字段模型的初始化工作，主要完成对CSS，JS信息的抓取。对其它配置信息的抓取。
     * @param    某个字段类型                   &$FieldDataXXXModel 
     * @return                                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-26T13:56:15+0800
     */
    public function init(&$FieldDataXXXModel = null)
    {
        $this->FieldDataXXXModel    = $FieldDataXXXModel;

        // 送入依赖css, 用于在footer中进行统一引用。
        if (isset($FieldDataXXXModel->getConfig()['css'])) {
            Common::addCss($FieldDataXXXModel->getConfig()['css']['value']);
        }

        // 送入依赖js, 用于在footer中进行统一引用。
        if (isset($FieldDataXXXModel->getConfig()['js'])) {
            Common::addJs($FieldDataXXXModel->getConfig()['js']['value']);
        }

        // 传入配置信息
        $this->config = $FieldDataXXXModel->getSimpleConfig();
        $this->assign('config', $this->config);
        $this->assign('FieldDataXXXModel', $FieldDataXXXModel);
        $this->assign('randId', rand(1,1023));    // 建立1个1023以内的随机数，防止ID重复
    }


    /**
     * 渲染字段模型（输出字段模型对应的HTML标签）
     * 被 FieldModel的render()函数 调用
     * @param    FieldDataXXXModel                   &$FieldDataXXXModel 字段数据模型
     * @return   String                                    对应的html标签代码
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T08:32:24+0800
     */
    static public function renderFieldDataModel(&$FieldDataXXXModel, $action)
    {
        // 首先对权限进行判断,不存在权限，则直接返回''
        if (!AccessUserGroupFieldModel::checkCurrentUserIsAllowedByFieldId($FieldDataXXXModel->getData('field_id'))) {
            return '';
        }

        $typeName = $FieldDataXXXModel->FieldModel()->getData('field_type_name');
        $className = 'app\field\controller\\' . ucfirst($typeName) . 'Controller';
        if (class_exists($className)) {
            // 实例化字段,然后调用init()进行实始化 ，调用fetchHtml()进行渲染
            $FieldXXXController = new $className();
            $FieldXXXController->init($FieldDataXXXModel);
            return $FieldXXXController->$action();
        } else {
            return 'field type is ' . $typeName . '. But ' . $className . '::' . 'index not found!';
        }
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
        // 获取调用此方法的控制器名及方法名
        $controller = Common::getControllerName(get_called_class());
        $action = debug_backtrace()[1]['function'];

        // 拼接主题模板信息
        $themeTemplate = APP_PATH . 
            'theme' . DS . 
            $this->currentThemeModel->getData('name') . DS .
            'field' . DS .
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
            $template = 'field@' . $controller . '/' . $action;
        }

        // 初始化html css js字符串
        $html = $css = $js = '';

        // 渲染html
        $html = parent::fetch($template);

        // 尝试渲染js及css
        try {
            $js = parent::fetch('field@' . $controller . '/' . $action . 'Js');
        } catch (\Exception $e) {}

        try {
            $css = parent::fetch('field@' . $controller . '/' . $action . 'Css');
        } catch (\Exception $e) {}

        return $html . $js . $css;
    }


}