<?php
namespace app\module\controller;
/**
 * 文字视频介绍
 */
class ContentVideoController extends ModuleController
{
	protected $config = [];
	protected $filter = [];

	public function fetchHtml()
	{
		return $this->fetch('module@ContentVideo/fetchHtml');
	}
}