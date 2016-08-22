<?php
namespace app\component\controller;
use app\model\ContentModel;                 // 文章
use app\model\CategoryModel;                // 类别

class ContentController extends ComponentController
{
    protected $config = [
        'id' => ['title' => '文章', 'description' => '将选择的文章内容显示在组件中', 'type' => 'text', 'value' => '1'],
    ];
    protected $filter = [];

    public function readAction($id)
    {
        $ContentModel = ContentModel::get($id);
        var_dump($ContentModel);
    }

    public function editAction($id)
    {
        
    }

    public function indexAction()
    {

        $id = 1;
        if (array_key_exists('id', $this->config))
        {
            $id = $this->config['id']['value'];
        }
        $ContentModel = ContentModel::get($id);
        $this->assign('ContentModel', $ContentModel);

        return $this->fetch();
    }
}