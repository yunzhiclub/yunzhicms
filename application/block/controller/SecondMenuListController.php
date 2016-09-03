<?php
namespace app\block\controller;
use app\Common;

/**
 * 二节材大
 */
class SecondMenuListController extends BlockController
{
    public function fetchHtml()
    {
        return $this->fetch('block@SecondMenuList/fetchHtml');
    }
}