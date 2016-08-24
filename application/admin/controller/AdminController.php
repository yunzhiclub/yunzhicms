<?php
namespace app\admin\controller;
use think\Controller;

class AdminController extends Controller
{
    protected $config = [];         // 配置信息
    protected $filter = [];         // 过滤器信息
    public function __construct()
    {
        parent::__construct();
        if ($this->action == 'edit' || $this->action == 'read')
        {
            // 取出配置信息以及过滤器
        }
    }
}