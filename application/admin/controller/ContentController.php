<?php
namespace app\admin\controller;
use app\model\ContentModel;             // 文章

class ContentController extends AdminController
{
    public function indexAction($category_id)
    {
        $ContentModels = ContentModel::all();
        var_dump($ContentModels);
        return $this->fetch();
    }
}
