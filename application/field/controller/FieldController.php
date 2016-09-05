<?php
namespace app\field\controller;

use think\Controller;
use app\Common;
use think\Loader;
use think\Request;

class FieldController extends Controller
{
    private $FieldDataXXXModel = null;                  // 某个扩展字段的模型
    private $nameTag;                                   // 字段输出时的 name 标签
    private $token;                                     // token

    /**
     * 字段的交互信息，全部传入此action，再经由此action进行权限判断及安全处理后调用相关的action
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T16:33:41+0800
     */
    public function ajaxAction()
    {
        // 检测传入的token是否有效
        // 根据传入的token，调用相同的action
        // 取出token对应的action
        // 送入相关类对应的action方法（注意：在此的action对应当前组件action）
    }


    public function init(&$FieldDataXXXModel = null)
    {
        // TODO：添加调用的JS外部链接。然后统一生成在footer的js区域
        // 
        
        $this->FieldDataXXXModel = $FieldDataXXXModel;
        // 生成token, makeToken函数，必须重写，否则调无法调用
        $this->token = $this->makeToken();

        // 传值
        $this->assign('token', $this->token);
        $this->assign('FieldDataXXXModel', $FieldDataXXXModel);
    }

    /**
     * 渲染字段模型（输出字段模型对应的HTML标签）
     * 被 FieldModel的render()函数 调用
     * @param    FieldDataXXXModel                   &$FieldDataXXXModel 字段数据模型
     * @return   String                                    对应的html标签代码
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T08:32:24+0800
     */
    static public function renderFieldDataModel($labelType, &$FieldDataXXXModel)
    {
        $className = 'app\field\controller\\' . ucfirst($labelType) . 'Controller';
        if (class_exists($className))
        {
            $FieldXXXController = new $className();
            $FieldXXXController->init($FieldDataXXXModel);
            return $FieldXXXController->fetchHtml();
        } else {
            return 'field type is ' . $labelType . '. But ' . $className . ' not found in Label module!';
        }
    }

    /**
     * 获取处理后的html代码
     * @return   String                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T09:51:51+0800
     */
    public function fetchHtml()
    {
        $calledClassName = Common::getControllerName(get_called_class());
        $html = $this->fetch('field@' . $calledClassName . '/fetchHtml');
        $js = $this->fetch('field@' . $calledClassName . '/fetchJavascript');
        return $html . $js;
    }

    /**
     * 生成认证使用的token
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T15:38:43+0800
     */
    public function makeToken()
    {
        // 如果你的字段有ajax或其它交互，则必须重写此函数：
        $module         = 'field';
        $controller     = 'Field';
        $action         = 'init';
        return Common::makeTokenByMCA($module, $controller, $action);
    }
}