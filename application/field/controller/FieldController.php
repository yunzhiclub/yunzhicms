<?php
namespace app\field\controller;

use think\Controller;
use app\Common;
use think\Loader;
use think\Request;

class FieldController extends Controller
{
    private $FieldDataXXXModel = null;                  // 某个扩展字段的模型
    private $FieldModel;                                // 字段模型
    private $nameTag;                                   // 字段输出时的 name 标签
    private $token;                                     // token
    private $config;                                    // 配置信息

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

    public function init(&$FieldModel, &$FieldDataXXXModel = null)
    {
        $this->FieldModel           = $FieldModel;
        $this->FieldDataXXXModel    = $FieldDataXXXModel;

        // 送入依赖css, 用于在footer中进行统一引用。
        if (isset($FieldDataXXXModel->getConfig()['css'])) {
            Common::addCss($FieldDataXXXModel->getConfig()['css']['value']);
        }

        // 送入依赖js, 用于在footer中进行统一引用。
        if (isset($FieldDataXXXModel->getConfig()['js'])) {
            Common::addJs($FieldDataXXXModel->getConfig()['js']['value']);
        }

        // 传值
        $this->assign('token', $this->FieldDataXXXModel->makeToken());        // 传入token，用于进行二次调用
        $this->assign('FieldModel', $FieldModel);
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
    static public function renderFieldDataModel(&$FieldModel, &$FieldDataXXXModel)
    {
        $typeName = $FieldModel->FieldTypeModel()->getData('name');
        $className = 'app\field\controller\\' . ucfirst($typeName) . 'Controller';
        if (class_exists($className))
        {
            $FieldXXXController = new $className();
            $FieldXXXController->init($FieldModel, $FieldDataXXXModel);
            return $FieldXXXController->fetchHtml();
        } else {
            return 'field type is ' . $typeName . '. But ' . $className . ' not found in Label module!';
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
        // 建立1个1024以内的随机数，防止ID重复
        $this->assign('randId', mt_rand(1, 1024));

        $calledClassName = Common::getControllerName(get_called_class());
        $html = $css = $js = '';

        $html = $this->fetch('field@' . $calledClassName . '/fetchHtml');

        try {
            $js = $this->fetch('field@' . $calledClassName . '/fetchJavascript');
        } catch (\Exception $e) {}

        try {
            $css = $this->fetch('field@' . $calledClassName . '/fetchCss');
        } catch (\Exception $e) {}

        return $html . $js . $css;
    }

}