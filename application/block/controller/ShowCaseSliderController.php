<?php
namespace app\block\controller;
/**
 * 动态案例展示
 */
class ShowCaseSliderController extends BlockController
{
    public function index()
    {
        return $this->fetch('block@ShowCaseSlider/fetchHtml');
    }
}