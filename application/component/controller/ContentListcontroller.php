<?php
namespace app\component\controller;

class ContentListController extends ComponentController
{
    public function indexAction()
    {
        echo 'contentList index';
    }
    public function readAction($config = [])
    {
    }

    public function editAction($config = [])
    {
        var_dump($this->method);
        $id = input('param.');
        var_dump($id);
    }
}