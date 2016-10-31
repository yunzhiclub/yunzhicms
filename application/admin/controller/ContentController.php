<?php
namespace app\admin\controller;
use app\model\ContentModel;             // 文章
use app\model\ContentTypeModel;         // 文章类别

class ContentController extends AdminController
{
    // public function indexAction($category_id)
    // {
    //     $map = [];

    //     // 按列表取值
    //     if ($category_id != 0)
    //     {
    //         $map['category_name'] = $category_id;
    //     }

    //     $ContentModels = ContentModel::all($map);
    //     $this->assign('ContentModels', $ContentModels);
    //     return $this->fetch();
    // }

    public function createAction()
    {
        //取出内容类型
        $map = array('is_delete' => 0);
        $ContentTypeModel  = new ContentTypeModel;
        $ContentTypeModels = $ContentTypeModel->where($map)->select();
        $this->assign('ContentTypeModels', $ContentTypeModels);
        return $this->fetch('Content/create');
    }

    public function saveAction()
    {
        $data = input('param.');
        $ContentModel = new ContentModel;
        $ContentModel->setData('title', $data['title']);
        $ContentModel->setData('content_type_name', $data['content_type_name']);
        $ContentModel->setData('is_freezed', $data['is_freezed']);
        $ContentModel->setData('weight', $data['weight']);

        //验证并保存
        if (false === $ContentModel->save($data)) {
            return $this->error("保存失败,请检查所填的内容正确与完整");
        }

        $contentType = $ContentModel->content_type_name;
        return $this->success('保存成功', url('ContentType/read', ['name' => $contentType]));
    }

    public function deleteAction($id)
    {
        $ContentModel = ContentModel::get($id);

        //获取删除时间并保存
        $time = time();
        $ContentModel->setData('delete_time', $time);
        $ContentModel->setData('is_delete', 1)->save();

        //返回成功
        $contentType = $ContentModel->content_type_name;
        return $this->success('删除成功', url('ContentType/read', ['name' => $contentType]));
    }

    public function editAction($id)
    {
        //取出对象
        $ContentModel = ContentModel::get($id);
        $this->assign('ContentModel', $ContentModel);

        //取出内容类型
        $map = array('is_delete' => 0);
        $ContentTypeModel  = new ContentTypeModel;
        $ContentTypeModels = $ContentTypeModel->where($map)->select();
        $this->assign('ContentTypeModels', $ContentTypeModels);

        return $this->fetch('Content/edit');
    }

    public function updateAction()
    {
        $data = input('param.');
        $id   = $data['id'];
        $ContentModel = ContentModel::get($id);
        $ContentModel->setData('title', $data['title']);
        $ContentModel->setData('content_type_name', $data['content_type_name']);
        $ContentModel->setData('is_freezed', $data['is_freezed']);
        $ContentModel->setData('weight', $data['weight']);

        //验证并保存
        if (false === $ContentModel->save()) {
            return $this->error('更新失败');
        }

        //返回成功
        $contentType = $ContentModel->content_type_name;
        return $this->success('更新成功', url('ContentType/read', ['name' => $contentType]  ));
    }
}
