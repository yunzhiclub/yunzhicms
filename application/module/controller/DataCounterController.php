<?php
namespace app\module\controller;
/**
 * 数据统计
 */
class DataCounterController extends ModuleController
{
	protected $config = [];
	protected $filter = [];

	public function fetchHtml()
	{
		return $this->fetch('module@DataCounter/fetchHtml');
	}
}