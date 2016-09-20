<?php
namespace app\field\controller;

use think\Controller;
use app\Common;
use think\Loader;
use think\Request;

use app\model\AccessUserGroupFieldModel;            // 用户组字段权限

class FieldController extends Controller
{
    protected $FieldDataXXXModel = null;                    // 某个扩展字段的模型
    protected $FieldModel;                                  // 字段模型
    private $nameTag;                                       // 字段输出时的 name 标签
    private $token;                                         // token
    protected $config;                                      // 配置信息

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
        if (class_exists($className))
        {
            // 实例化字段,然后调用init()进行实始化 ，调用fetchHtml()进行渲染
            $FieldXXXController = new $className();
            $FieldXXXController->init($FieldDataXXXModel);
            return $FieldXXXController->$action();
        } else {
            return 'field type is ' . $typeName . '. But ' . $className . '::' . 'index not found!';
        }
    }

    /**
     * 获取处理后的html代码
     * @return   String                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T09:51:51+0800
     */
    public function renderAction($action)
    {
        // 建立1个1024以内的随机数，防止ID重复
        $this->assign('randId', mt_rand(1, 1024));

        $calledClassName = Common::getControllerName(get_called_class());
        $html = $css = $js = '';

        $html = $this->fetch('field@' . $calledClassName . '/' . $action);

        try {
            $js = $this->fetch('field@' . $calledClassName . '/' . $action . 'Javascript');
        } catch (\Exception $e) {}

        try {
            $css = $this->fetch('field@' . $calledClassName . '/' . $action . 'Css');
        } catch (\Exception $e) {}

        return $html . $js . $css;
    }



}