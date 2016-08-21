<?php
namespace app\module\controller;
/**
 * 文字视频介绍
 */
class CaseshowController extends ModuleController
{
	protected $config = [];
	protected $filter = [];

	public function fetchHtml()
	{
		return $this->fetch('module@Caseshow/fetchHtml');
	}
}