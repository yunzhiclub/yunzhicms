<?php
namespace app\plugin\controller;
use app\model\ContentModel;                     // 文章
/**
 * 上一条新闻 下一条新闻
 */
class PreNextContentController extends PluginController
{
    public function fetchHtml(ContentModel $ContentModel)
    {
        return '';
    }
}