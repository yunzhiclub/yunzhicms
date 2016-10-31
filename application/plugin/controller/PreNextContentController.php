<?php
namespace app\plugin\controller;
use app\model\ContentModel;                 // 文章

/**
 * 上一条新闻 下一条新闻
 */
class PreNextContentController extends PluginController
{
    public function fetchHtml(ContentModel $ContentModel)
    {
        // 获取上一条新闻
        $preContentModel = $ContentModel->getPreContentModel();
        // 获取下一条新闻
        $nextContentModel = $ContentModel->getNextContentModel();

        // 传入V层
        $this->assign('preContentModel', $preContentModel);
        $this->assign('nextContentModel', $nextContentModel);

        // 取V层
        return $this->fetch('plugin@PreNextContent/fetchHtml');
    }
}