<?php
namespace app\block\controller;
/**
 * 数据统计
 */
class DataCounterController extends BlockController
{
	public function index()
	{
		return $this->fetch('block@DataCounter/fetchHtml');
	}
}