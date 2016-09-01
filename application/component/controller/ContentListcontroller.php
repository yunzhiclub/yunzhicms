<?php
namespace app\component\controller;
use app\model\ContentModel;                 // 文章

class ContentListController extends ComponentController
{
    public function indexAction()
    {
        $ContentModel = new ContentModel();
        $map = [];
        $map['content_type_name'] = $this->config['contentTypeName']['value'];
        $map['is_freezed'] = '0';
        $map['is_deleted'] = '0';
        $ContentModels = $ContentModel->where($map)->paginate($this->config['count']['value']);

        $this->assign('ContentModels', $ContentModels);
        return $this->fetch();
    }


    public function readAction($id)
    {   
        $map = ['id' => $id];
        $ContentModel = ContentModel::get($map);
        $this->assign('ContentModel', $ContentModel);

        // 增加一个点击量
        $ContentModel->hit = $ContentModel->hit + 1;
        $ContentModel->save();

        return $this->fetch();
    }

    public function editAction($id)
    {
        var_dump($id);
        $id = input('param.');
        var_dump($id);
    }
}