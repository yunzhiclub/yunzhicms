<?php
namespace app\filter\server;

use app\Common;
use app\model\MenuModel;
use app\model\ContentModel;         // 文章

class SystemServer
{
    /**
     * 生成首页新闻链接
     * @param  int $id    新闻ID
     * @param  array $param 参数
     * @return string        生成的URL地址
     */
    static public function makeFrontpageContentUrl($id, $param = [])
    {
        return url('@hotnews/' . $id);
    }

    /**
     * 生成当前菜单的URL
     * @param  int $id    新闻ID
     * @param  array  $param 参数
     * @return string       生成的URL地址
     */
    static public function makeCurrentMenuReadUrl($id, $param = [])
    {
        $currentMenuModle = MenuModel::getCurrentMenuModel();
        return url('@' . $currentMenuModle->url . '/' . $id);
    }


    /**
     * 生成 文章 的Read地址
     * @param  ContentModel  $ContentModel    文章
     * @param  array  $param 传入配置参数
     * @return string        生成的URL地址
     */
    static public function makeContentReadUrl($ContentModel, $param = [])
    {
        // 查找路由URL，并按LCURD给出R的信息
        
        $url = $ContentModel->ContentTypeModel()->MenuModel()->getData('url');
        return url('@' . $url . '/' . $ContentModel->getData('id'));
    }

    static public function htmlspecialchars_decode($html, $param = [])
    {
        return htmlspecialchars_decode($html);
    }
}