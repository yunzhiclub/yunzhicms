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

    public function ajaxAction()
    {
        // 检测传入的token是否有效
        // 根据传入的token，调用相同的action
        // 取出token对应的action
        // 送入相关类对应的action方法（注意：在此的action对应当前组件action）
    }


    public function init(&$FieldDataXXXModel = null)
    {
        $this->FieldDataXXXModel = $FieldDataXXXModel;

        // 生成token
        $this->token = $this->makeToken();
        var_dump($this->token);
        var_dump(session('tokens'));
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
        return $this->fetch('field@' . $calledClassName . '/fetchHtml');
    }

    /**
     * 生成认证使用的token
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T15:38:43+0800
     */
    public function makeToken()
    {
        throw new \Exception("must rewrite this function!", 1);

        // 必须重写此函数，示例代码如下：
        $module         = 'field';
        $controller     = 'Field';
        $action         = 'init';
        return Common::makeTokenByMCA($module, $controller, $action);
    }
}