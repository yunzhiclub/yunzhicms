<?php
namespace app\block\controller;
/**
 * 幻灯片
 */
class SliderController extends BlockController
{
    public function fetchHtml()
    {
        return $this->fetch('block@Slider/fetchHtml');
    }
}