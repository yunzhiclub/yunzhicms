<?php
namespace app\filter\server;
use app\model\MenuModel;
use app\Common;

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
        return url('component/Content/read?id=' . $id);
    }

    /**
     * 生成当前菜单的URL
     * @param  int $id    新闻ID
     * @param  array  $param 参数
     * @return string       生成的URL地址
     */
    static public function makeCurrentMenuReadUrl($id, $param = [])
    {
        $currentMenuModle = Common::toggleCurrentMenuModel();
        return url('@' . $currentMenuModle->url . '/' . $id);
    }
}