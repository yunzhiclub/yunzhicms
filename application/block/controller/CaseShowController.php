<?php
namespace app\block\controller;
/**
 * 文字视频介绍
 */
class CaseshowController extends BlockController
{
	public function fetchHtml()
	{
		return $this->fetch('block@Caseshow/fetchHtml');
	}
}