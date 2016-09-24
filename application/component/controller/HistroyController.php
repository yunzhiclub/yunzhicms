<?php
namespace app\component\controller;

use think\Request;

use app\model\ContentModel;                 // 文章
use app\model\FieldModel;                   // 扩展字段

class HistroyController extends ComponentController
{
    public function indexAction()
    {
       return $this->fetch(); 
    }
}