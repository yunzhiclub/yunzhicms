<?php
namespace app\module\controller;
use app\Common;

/**
 * BreakCrumb
 */
class BreadCrumbController extends ModuleController
{
    protected $config = [];
    protected $filter = [];

    public function fetchHtml()
    {
        $currentMenuModel = Common::toggleCurrentMenuModel();
        $MenuModels = $currentMenuModel->getFatherMenuModleTree();

        $this->assign('MenuModels', $MenuModels);
        return $this->fetch('module@BreadCrumb/fetchHtml');
    }
}