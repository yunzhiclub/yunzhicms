<?php
namespace app\admin\controller;
use app\model\ContentModel;             // 文章
use app\model\ContentTypeModel;         // 文章类别

class ContentController extends AdminController
{
    public function indexAction($category_id)
    {
        $map = [];

        // 按列表取值
        if ($category_id != 0)
        {
            $map['category_name'] = $category_id;
        }

        $ContentModels = ContentModel::all($map);
        $this->assign('ContentModels', $ContentModels);
        return $this->fetch();
    }
}
