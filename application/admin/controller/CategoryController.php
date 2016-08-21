<?php
namespace app\admin\controller;
use app\model\CategoryModel;                // 类别

class CategoryController extends AdminController
{
    public function indexAction()
    {
        $CategoryModels = CategoryModel::paginate();
        $this->assign('CategoryModels', $CategoryModels);
        return $this->fetch();
    }
}
