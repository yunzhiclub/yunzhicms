<?php
namespace app\module\controller;
/**
 * 动态案例展示
 */
class ShowCaseSliderController extends ModuleController
{
    public function fetchHtml()
    {
        return $this->fetch('module@ShowCaseSlider/fetchHtml');
    }
}