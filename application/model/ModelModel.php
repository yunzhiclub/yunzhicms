<?php
namespace app\model;
use app\YunzhiModel;
use app\Common;

class ModelModel extends YunzhiModel
{
    protected $filterModels = null;             // 过滤器模型信息
    protected $type = [
        'config'    => 'json',
        'filter'    => 'json',
        'param'     => 'json',
    ];

    public function getConfigAttr()
    {
        return json_decode($this->getData('config'), true);
    }

    public function getFilterAttr()
    {
        return json_decode($this->getData('filter'), true);
    }

    /**
     * 获取过滤器模型
     * @return lists FilterModels
     */
    public function getFilterModels()
    {
        if (null === $this->filterModels)
        {
            $this->filterModels = array();
            $filters = $this->getFilter();
            foreach ($filters as $key => $filter)
            {
                $this->filterModels[$key] = FilterModel::getFilterModelByArray($filter);
            }
        }

        return $this->filterModels;
    }
}