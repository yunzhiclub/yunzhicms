<?php
namespace app\model;

class PluginTypeModel extends ModelModel
{
    protected $pk = 'name';
    public function getConfigAttr()
    {
        return json_decode($this->getData('config'), true);
    }

    public function getFilterAttr()
    {
        return json_decode($this->getData('filter'), true);
    }
}