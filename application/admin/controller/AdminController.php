<?php
namespace app\admin\controller;
use think\Controller;

class AdminController extends Controller
{
    protected $currentUserModel = null;
    public function __construct()
    {
        parent::__construct();
    }
}