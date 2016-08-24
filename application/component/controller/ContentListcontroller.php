<?php
namespace app\component\controller;
use app\model\ContentModel;                 // 文章

class ContentListController extends ComponentController
{
    protected $config = [
        'categoryName' => ['type' => 'text', 'title' => '文章类别', 'description' => '显示哪个类别的文章', 'value' => 'news'],
        'count' => ['type' => 'text', 'title' => '每页大小', 'description' => '每页显示多少篇文章', 'value' => '1'],
        'order' => ['type' => 'text', 'title' => '排序方式', 'description' => '数据字段的排序方式', 'value'=>'weight desc, id desc']
    ];

    protected $filter = [
        'title' => ['type' => 'String', 'function' => 'substr', 'param'=>['length'=>30, 'etc' => '..']],
        'href'  => ['type' => 'System', 'function' => 'makeCurrentMenuReadUrl'],
        'date'  => ['type' => 'date', 'function' => 'formart', 'param' => 'Y-m-d'],
    ];

    public function indexAction()
    {
        $ContentModel = new ContentModel();
        $map = [];
        $map['category_name'] = $this->config['categoryName']['value'];
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

    public function editAction($config = [])
    {

        var_dump($this->method);
        $id = input('param.');
        var_dump($id);
    }
}