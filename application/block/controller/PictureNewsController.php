<?php
namespace app\block\controller;
/**
 * 图文列表-首页
 */
class PictureNewsController extends BlockController
{
    public function index()
    {
        return $this->fetch('block@PictureNews/fetchHtml');
    }
}
