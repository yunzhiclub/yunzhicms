<?php
namespace app\component\controller;

use think\Request;

use app\model\ContentModel;                 // 文章
use app\model\FieldModel;                   // 扩展字段

/**
 * todo:权限判断。即当前新闻，是否属于当前这个菜单对应的那个 新闻类别
 */
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
        // 更新当前新闻信息
        $ContentModel = ContentModel::get(['id' => $id]);

        $this->assign('ContentModel', $ContentModel);

        return $this->fetch();
    }


    public function updateAction($id)
    {
        // 更新当前新闻信息
        $ContentModel = ContentModel::get(['id' => $id]);

        // 获取数据
        $data = Request::instance()->param();

        // 更新当前新闻信息
        $ContentModel->setData('title', $data['title']);
        $ContentModel->save();

        // 更新扩展数据字段
        if (isset($data['field_'])) {
            FieldModel::updateLists($data['field_'], $ContentModel->getData('id'));
        }

        // 成功返回
        return $this->success('操作成功', url('@' . $this->currentMenuModel->getData('url')));
    }
}
