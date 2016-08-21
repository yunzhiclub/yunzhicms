<?php
namespace app\model;

class ComponentModel extends YunzhiModel
{
    static public function getCurrentComponent($component)
    {
        $arr = explode('\\', $component);
        $componentName = array_pop($arr);
        $componentName = substr($componentName, 0, -strlen('Controller'));
        $map = ['name'=>$componentName];
        return ComponentModel::get($map);
    }
}