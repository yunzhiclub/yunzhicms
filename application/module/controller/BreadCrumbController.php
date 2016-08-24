<?php
namespace app\module\controller;
use app\Common;

/**
 * BreakCrumb
 */
class BreadCrumbController extends ModuleController
{
    public function fetchHtml()
    {
        $MenuModels = $this->currentMenuModel->getFatherMenuModleTree();

        $this->assign('MenuModels', $MenuModels);
        return $this->fetch('module@BreadCrumb/fetchHtml');
    }
}