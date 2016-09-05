<?php
namespace app\label\controller;

use think\Controller;
use app\Common;

class LabelController extends Controller
{
    private $FieldDataModel = null;

    public function __construct(&$FieldDataModel = null)
    {
        parent::__construct();
        $this->FieldDataModel = $FieldDataModel;
        $this->assign('FieldDataModel', $FieldDataModel);
    }

    /**
     * 渲染字段模型（输出字段模型对应的HTML标签）
     * 被 FieldModel的render()函数 调用
     * @param    FieldDataModel                   &$FieldDataModel 字段数据模型
     * @return   String                                    对应的html标签代码
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T08:32:24+0800
     */
    static public function renderFieldDataModel(&$FieldDataModel)
    {
        $fieldType = $FieldDataModel->FieldModel()->FieldTypeModel()->getData('type');
        $className = 'app\label\controller\\' . ucfirst($fieldType) . 'Controller';
        if (class_exists($className))
        {
            $LabelController = new $className($FieldDataModel);
            return $LabelController->fetchHtml();
        } else {
            return 'field type is ' . $fieldType . '. But ' . $className . ' not found in Label module!';
        }
    }

    public function fetchHtml()
    {
        $calledClassName = Common::getControllerName(get_called_class());
        return $this->fetch('label@' . $calledClassName . '/fetchHtml');
    }
}