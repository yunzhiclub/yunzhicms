<?php
namespace app\component\controller;
use app\model\ContentFrontpageModel;                // 首页推荐内容

class HomeController extends ComponentController
{
    protected $config = [
        'count'=>['description'=>'显示新闻的条数', 'type'=>'text', 'value'=>3],
        ];

    protected $filter = [
        'title' => ['type' => 'String', 'function' => 'substr', 'param'=>['length'=>6, 'etc' => '..']],
        'href'  => ['type' => 'System', 'function' => 'makeFrontpageContentUrl'],
    ];

    public function indexAction()
    {
        // 定义配置信息
        $map = [];
        $offset = 10;
        $offset = $this->config['count']['value'];
        $order = ['weight'=>'desc', 'create_time'=>'desc'];

        // 取推荐新闻，并传给首页
        $ContentFrontpageModel = new ContentFrontpageModel;
        $ContentFrontpageModels = $ContentFrontpageModel->order($order)->limit(0, $offset)->select();
        $this->assign('ContentFrontpageModels', $ContentFrontpageModels);

        unset($ContentFrontpageModels);
        unset($ContentFrontpageModel);
        return $this->fetch();
    }
}