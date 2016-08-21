<?php
namespace app\module\controller;
/**
 * 菜单
 */
class SliderController extends ModuleController
{
    protected $config = [];
    protected $filter = [];

    public function fetchHtml()
    {
        return $this->fetch('module@Slider/fetchHtml');
    }
}