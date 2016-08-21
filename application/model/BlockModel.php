<?php
namespace app\model;
/**
 * 区块
 */
class BlockModel extends YunzhiModel
{
    /**
     * 获取某个position下的所有 启用 的区载信息
     * @param  string $name position名称
     * @return lists       BlockModels
     */
    public function getActiveListsByPositionName($name)
    {
        $map = ['position_name' => $name, 'status' => '0'];
        $order = ['weight' => 'desc', 'id' => 'desc'];
        return $this->where($map)->order($order)->select();
    }
}