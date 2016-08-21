<?php
namespace app\component\controller;
use app\model\ContentModel;                 // 文章

class ContentController extends ComponentController
{
    public function readAction($id)
    {
        $ContentModel = ContentModel::get($id);
        var_dump($ContentModel);
    }

    public function editAction($id)
    {
        
    }
}