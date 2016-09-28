<?php
namespace app\block\controller;
/**
 * 左侧最新的通知列表
 */
class LastestNewsController extends BlockController
{
	public function index()
	{
		return $this->fetch('block@LastestNews/fetchHtml');
	}
}