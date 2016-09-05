<?php
namespace app\label\controller;

use think\Controller;
use app\Common;
use think\Loader;

class LabelController extends Controller
{
    private $FieldDataXXXModel = null;                  // 某个扩展字段的模型
    private $nameTag;                                   // 字段输出时的 name 标签

    public function __construct(&$FieldDataXXXModel = null)
    {
        parent::__construct();
        $this->FieldDataXXXModel = $FieldDataXXXModel;
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
        $className = 'app\label\controller\\' . ucfirst($labelType) . 'Controller';
        if (class_exists($className))
        {
            $LabelController = new $className($FieldDataXXXModel);
            return $LabelController->fetchHtml();
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
        return $this->fetch('label@' . $calledClassName . '/fetchHtml');
    }
}