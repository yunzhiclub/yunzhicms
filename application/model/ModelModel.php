<?php
namespace app\model;
use app\YunzhiModel;

class ModelModel extends YunzhiModel
{
    // 自动时间戳
    protected $autoWriteTimestamp = true;
    protected $filterModels = null;             // 过滤器模型信息
    protected $type = [
        'config'    => 'json',
        'filter'    => 'json',
        'param'     => 'json',
    ];

    public function getFilter()
    {
        if (null === $this->filter)
        {
            // 合并当前菜单对应的组件过滤器及当前菜单的过滤器
            $this->filter = Common::configMerge($this->Component->filter, json_decode($this->data['filter'], true));
        }
        return $this->filter;  
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