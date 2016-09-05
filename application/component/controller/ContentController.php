<?php
namespace app\component\controller;
use app\Common;
use app\model\ContentModel;                 // 文章
use app\model\CategoryModel;                // 类别

class ContentController extends ComponentController
{
    private $ContentModel = null;

    public function __construct()
    {
        parent::__construct();

        // 获取配置信息中的当前文章ID
        $id = 0;
        if (array_key_exists('id', $this->config))
        {
            $id = $this->config['id']['value'];
        }        

        $this->ContentModel = ContentModel::get($id);
    }

    public function createAction()
    {
        $token = Common::makeToken();
        var_dump($token);
        var_dump(Common::checkIsAllowedByToken($token));
        $this->assign('ContentModel', $this->ContentModel);
        return $this->fetch();
    }

    public function saveAction()
    {
        var_dump(input('param.'));
    }

    public function indexAction()
    {
        $this->assign('ContentModel', $this->ContentModel);
        return $this->fetch();
    }
}