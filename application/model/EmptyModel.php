<?php
namespace app\model;
/**
 * 空类，用于生成默认类，防止连贯调用报错
 */
class EmptyModel
{
    public function __call($name, $args) 
    {
        return new self();
    }

    public function __callStatic($name, $args)
    {
        return new self();
    }

    public function __get($name)
    {
        return '';
    }

    public function __set($name, $value)
    {
        return new self();
    }
}