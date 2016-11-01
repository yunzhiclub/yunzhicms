<?php
namespace app\model;
use app\Common;

use app\model\FieldModel;                       // 字段

/**
 * 区块
 */
class BlockModel extends ModelModel
{
    private $BlockTypeModel = null;     // 区块类型
    private $FieldModels;               // 字段模型信息
    private $FieldXXXXModels = null;    // 扩展字段
    protected $config = null;           // 配置信息
    protected $filter = null;           // 过滤器信息
    protected $sampleConfig = null;     // 简单配置信息
    protected $route =null;             //类似路由信息

    /**
     * 默认的一些非 空字符串 的设置
     * 用来存在放在空的数据对象中
     */
    protected $data = [
        'config'    => '[]',
        'filter'    => '[]',
    ];


    /**
     * 区域:模块 = n:1
     */
    public function BlockTypeModel()
    {
        if (null === $this->BlockTypeModel) {
            $map = [];
            $map['name'] = $this->getData('block_type_name');
            $this->BlockTypeModel = BlockTypeModel::get($map);
        }

        return $this->BlockTypeModel;
    }

    /**
     * 获取合并后，可以供CV使用的配置信息   
     * @return array 
     */
    public function getConfig()
    {
        if (null === $this->config)
        {
            $this->config = Common::configMerge($this->BlockTypeModel()->getConfig(), $this->getConfigAttr());
        }
        return $this->config;
    }

    /**
     * 获取简单配置信息
     * @return   array                   key => value
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-22T09:54:03+0800
     */
    public function getSampleConfig()
    {
        if (null === $this->sampleConfig) {
            $configs = $this->getConfig();
            $this->sampleConfig = [];
            foreach ($configs as $key => $config) {
                $this->sampleConfig[$key] = $config['value'];
            }
        }

        return $this->sampleConfig;
    }
    /**
     * 获取合并后可以供前台使用的过滤器信息
     * @return array 
     */
    public function getFilter()
    {
        if (null === $this->filter)
        {
            $this->filter = Common::configMerge($this->BlockTypeModel()->getFilter(), $this->getFilterAttr());
        }

        return $this->filter;
    }

    public function FieldModels()
    {
        if (null === $this->FieldModels) {
            $this->FieldModels = FieldModel::getListsByRelateTypeRelateValue('Block', $this->getData('block_type_name'));
        }

        return $this->FieldModels;
    }

    /**
     * 内容对应的内段详情信息
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-19T08:40:37+0800
     */
    public function FieldXXXXModels()
    {
        if (null === $this->FieldXXXXModels) {
            $this->FieldXXXXModels = [];
            // 获取对应的全部字段的信息
            $FieldModels = $this->FieldModels();
            
            // 遍历当前 内容类型 的扩展字段信息.
            foreach ($FieldModels as $FieldModel) {
                array_push($this->FieldXXXXModels, $FieldModel->getFieldDataXXXModelByKeyId($this->getData('id')));
            } 
        }
        
        return $this->FieldXXXXModels;
    }
    /**
     * 获取某个position下的所有 启用 的区载信息
     * @param  string $name position名称
     * @return lists       BlockModels
     */
    public function getActiveListsByPositionName($name)
    {
        $map = ['position_name' => $name, 'status' => '0'];
        $order = ['weight' => 'desc'];
        $BlockModels = $this->where($map)->order($order)->select();
        foreach ($BlockModels as $key => &$BlockModel)
        {
            // 去除没有权限显示的区块
            if (!$BlockModel->isShowInCurrentMenu())
            {
                unset($BlockModels[$key]);
            }
        }
        return $BlockModels;
    }


    /**
     * 判断当前BLOCK是否在 正在访问的当前菜单 中显示
     * @return boolean 
     */
    public function isShowInCurrentMenu()
    {
        // 取出当前菜单
        $currentMenuModel = MenuModel::getCurrentMenuModel();

        // 判断当前菜单是否拥有此block的显示权限
        $map = ['block_id'=>$this->id, 'menu_id' => $currentMenuModel->id];
        $AccessBlockMenuModel = AccessMenuBlockModel::get($map);

        if ('' === $AccessBlockMenuModel->getData('menu_id'))
        {
            return false;
        } else {
            return true;
        }
    }

    public function checkIsShow(MenuModel &$MenuModel)
    {
        $map = [];
        $map['block_id']    = $this->data['id'];
        $map['menu_id']     = $MenuModel->getData('id');
        if (empty(AccessMenuBlockModel::get($map)->getData()))
        {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 生成前台可以直接调用的token
     * @param    string                   $action 
     * @return   string                           
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-08T09:47:07+0800
     */
    public function makeToken($action, $data = [])
    {
        // 对权限进行判断，没有权限，则返回空字符串
        if (AccessUserGroupBlockModel::checkCurrentUserIsAllowedByBlockIdAndAction($this->getData('id'), $action)) {
            $data = array_merge(['id' => $this->getData('id')], $data);
            $token = Common::makeTokenByMCAData('block', $this->BlockTypeModel()->getData('name'), $action, $data);
        } else {
            $token = '';
        }
        
        return $token;
    }


    /**
     * 通过扩展字段的 字段名 来获取字段内容
     * @param    string                   $fieldName 字段名
     * @return   Object                              FieldDataXXXModel 
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T14:13:25+0800
     */
    public function FieldModel($name)
    {
        if (empty($name)) {
            throw new \Exception("the param can't  empty", 1);
        }

        // 遍历当前 内容类型 的扩展字段信息.
        foreach ($this->FieldModels() as $FieldModel) {
            // 找到当字段，则返回当前字段对应的扩展字段对象
            if ($FieldModel->getData('name') === $name) {
                return $FieldModel->getFieldDataXXXModelByKeyId($this->getData('id'));
            }
        }

        throw new \Exception('not found fieldName:' . $name . ' of ContentModel:' . $this->getData('id'), 1);
    }

    public function checkIsHave(UserGroupModel &$UserGroupModel)
    {
        $map = [];
        $map['block_id']    = $this->data['id'];
        $map['user_group_name']     = $UserGroupModel->getData('name');
        if (empty(AccessUserGroupBlockModel::get($map)->getData()))
        {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 获取route文件中信息
     * @return array 
     * @author huangshuaibin
     */
    public function getRoute()
    {
        if (null === $this->route) {
            $routeFilePath = APP_PATH . 
                'block' . DS . 
                'route' . DS .
                $this->getData('block_type_name') . 'Route.php';
            $routeFilePath = realpath($routeFilePath);
            if (false === $routeFilePath) {
                $this->route = [];
            } else {
                $this->route = include $routeFilePath;
            }
        }

        return $this->route;
    }
}
