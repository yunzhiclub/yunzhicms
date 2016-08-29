<?php
namespace app\block\controller;
use app\Common;

/**
 * BreakCrumb
 */
class BreadCrumbController extends BlockController
{
    public function fetchHtml()
    {
        $MenuModels = $this->currentMenuModel->getFatherMenuModleTree();

        $this->assign('MenuModels', $MenuModels);
        return $this->fetch('block@BreadCrumb/fetchHtml');
    }
}