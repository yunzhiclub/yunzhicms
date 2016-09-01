<?php
namespace app\admin\controller;
use app\model\ContentTypeModel;                // 类别

class ContentTypeController extends AdminController
{
    public function indexAction()
    {
        $ContentTypeModels = ContentTypeModel::paginate();
        $this->assign('ContentTypeModels', $ContentTypeModels);
        return $this->fetch();
    }
}
