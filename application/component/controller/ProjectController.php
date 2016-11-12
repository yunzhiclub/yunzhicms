<?php
namespace app\component\controller;

use think\Request;

use app\model\ContentModel;                 // 文章
use app\model\FieldModel;                   // 扩展字段

/**
 * todo:权限判断。即当前新闻，是否属于当前这个菜单对应的那个 新闻类别
 */
class ProjectController extends ComponentController
{
    public function indexAction()
    {
        
        return $this->fetch();
    }


  
}
