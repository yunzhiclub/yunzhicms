<?php
namespace app\block\controller;
/**
 * 页脚显示
 */
class FooterController extends BlockController
{
    public function index()
    {
        return $this->fetch('block@Footer/fetchHtml');
    }
}
