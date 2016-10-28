<?php
namespace app\component\controller;
use app\model\ContentFrontpageModel;                // 首页推荐内容

class HomeController extends ComponentController
{
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

    public function readAction($id)
    {
        var_dump($id);
    }
}