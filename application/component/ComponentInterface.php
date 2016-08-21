<?php
namespace app\component;
/**
 * 组件接口
 */
interface ComponentInterface
{
    public function __construct();
    public function indexAction();
    public function createAction();
    public function saveAction();
    public function readAction($id);
    public function editAction($id);
    public function updateAction();
    public function deleteAction($id);
}