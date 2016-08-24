<?php
namespace app\model;

class CategoryModel extends ModelModel
{

    protected $pk = 'name';

    public function getName()
    {
        return $this->name;
    }
}