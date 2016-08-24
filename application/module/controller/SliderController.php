<?php
namespace app\module\controller;
/**
 * 幻灯片
 */
class SliderController extends ModuleController
{
    public function fetchHtml()
    {
        return $this->fetch('module@Slider/fetchHtml');
    }
}