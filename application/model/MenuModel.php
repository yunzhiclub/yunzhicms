<?php
namespace app\model;
use think\Request;
use app\Common;

class MenuModel extends ModelModel
{
    static private $currentMenuModel = null;    // 当前菜单
    
    private $config             = null;         // 配置信息
    private $filter             = null;         // 过滤器信息
    private $depth              = 0;            // 菜单深度
    private $ComponentModel     = null;         // 对应的组件

    private $availableSonMenuModels = null;     // 可用的子菜单列表
    private $isHaveAvailableSonMenus = null;    // 是否存在可用的子菜单列表

    protected $fatherMenuModel  = null;
    /**
     * 默认的一些非 空字符串 的设置
     * 用来存在放在空的数据对象中
     */
    protected $data = [
        'config'    => '[]',
        'filter'    => '[]',
    ];

    public function setDepth($depth) {
        $this->depth = $depth;
    }

    public function getRoute()
    {
        if (null === $this->route) {
            
        }

        return $this->route;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function getConfigAttr()
    {
        return json_decode($this->getData('config'), true);
    }

    public function getFilterAttr()
    {
        return json_decode($this->getData('filter'), true);
    }

    public function getFilter()
    {
        if (null === $this->filter)
        {
            // 合并当前菜单对应的组件过滤器及当前菜单的过滤器
            $this->filter = Common::configMerge($this->ComponentModel()->getFilter(), $this->getFilterAttr());
        }
        return $this->filter;  
    }

    public function ComponentModel()
    {
        if (null === $this->ComponentModel) {
            $map = [];
            $map['name'] = $this->getData('component_name');
            $this->ComponentModel = ComponentModel::get($map);
        }

        return $this->ComponentModel;
    }

    public function getConfig()
    {
        if (null === $this->config)
        {
            // 合并当前菜单对应的组件配置及当前菜单的配置
            $this->config = Common::configMerge($this->ComponentModel()->getConfig(), $this->getConfigAttr());
        }

        return $this->config;
    }

    /**
     * 获取用户当前访问的菜单
     * @return MenuModel 
     */
    static public function getCurrentMenuModel()
    {
        if (null === self::$currentMenuModel)
        {
            // 定义路由关键字
            $routeKeys = ['edit', ':id', 'delete', 'create', 'save'];
            $routeInfo = Request::instance()->routeInfo();
            $rule = $routeInfo['rule'];
            
            // 如果是空信息，则说明执行的为首页。手动添加首页路由规则
            if (!is_array($rule)) {
                $rule = [""];
            }
            
            // 对路由信息进行接拼后，依次次查询菜单表，如果菜单url与当前拼接的URL相同，则认为找到了菜单项
            $map = [];
            do {
                $map['url'] = implode('/', $rule);
                self::$currentMenuModel = MenuModel::get($map);
            } while ('' === self::$currentMenuModel->getData('id') && array_pop($rule));

            // 未找到菜单项，则默认返回首页
            if ('' === self::$currentMenuModel->getData('id')) {
                $map = ['is_home' => 1];
                self::$currentMenuModel = self::get($map);
            }
        }

        return self::$currentMenuModel;
    }

    /**
     * 获取某个菜单类型的所有的列表
     * 先转化为树状，先转化为列表，这样顺序输出后，就有了上下级的结构
     * @param  string $menuTypeName 菜单类型名 int pid $pid 父级菜单的id int $is_deleted 是否删除标记
     * @return lists               
     * 
     */
    public function getListsByMenuTypeNamePid($menuTypeName, $pid, $is_deleted = null )
    {
        $map = ['menu_type_name' => $menuTypeName, 'pid' => $pid, 'is_deleted' => $is_deleted];
        $MenuModels = $this->where($map)->order('weight desc')->select();
        return $MenuModels;
    }

    /**
     * 父菜单
     * @return MenuModel 
     */
    public function fatherMenuModel()
    {
        if (null === $this->fatherMenuModel) {
            $map = ['id' => $this->getData('pid')];
            $this->fatherMenuModel = self::get($map);
        }

        return $this->fatherMenuModel;
    }

    /**
     * 菜单是否被激活
     * @return boolean 
     * todo: 多级菜单的激活判断
     */
    public function isActive()
    {
        $currentMenuModel = self::getCurrentMenuModel();
        
        do {

            if ($this->getData('id') === $currentMenuModel->getData('id'))
            {
                return 1;
            }

            $currentMenuModel = $currentMenuModel->fatherMenuModel();
        } while ('' !== $currentMenuModel->getData('id'));

        return 0;
    }

    /**
     * 当前菜单是否存在子菜单
     * @return boolean 
     */
    public function isHaveSon()
    {
        $menuModels = $this->sonMenuModels();
        if (empty($menuModels))
        {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * 当前菜单是否存在可用的子菜单
     * 主要考虑两方面因素：
     * 1. 子菜单是否可见
     * 2. 当前访问用户是否拥有当前菜单的读权限
     * @return boolean [description]
     */
    public function isHaveAvailableSonMenus()
    {
        if (null === $this->isHaveAvailableSonMenus)
        {
            $availableSonMenuModels = $this->getAvailableSonMenuModels();
            if (empty($availableSonMenuModels))
            {
                $this->isHaveAvailableSonMenus = false;
            } else {
                $this->isHaveAvailableSonMenus = true;
            }
        }

        return $this->isHaveAvailableSonMenus;
    }

    /**
     * 获取可用的子菜单列表：
     * 主要考虑两方面因素：
     * 1. 子菜单是否可见
     * 2. 当前访问用户是否拥有当前菜单的 读 权限
     * @return lists
     */
    public function getAvailableSonMenuModels()
    {
        if (null === $this->availableSonMenuModels)
        {
            // 找到当前用户组(每个用户只能有一个用户组)
            $currentFrontUserModel = UserModel::getCurrentFrontUserModel();
            $currentFrontUserGroupModel = $currentFrontUserModel->UserGroupModel();

            $map = ['pid' => $this->getData('id'), 'status' => 0, 'is_hidden' => '0'];
            $this->availableSonMenuModels = $this->where($map)->select();
            foreach ($this->availableSonMenuModels as $key => $MenuModel) {
                if (!$currentFrontUserGroupModel->isIndexAllowedByMenuModel($MenuModel))
                {
                    unset($this->availableSonMenuModels[$key]);
                }
            }
        }

        return $this->availableSonMenuModels;
    }

    /**
     * 当前菜单的子菜单
     * 以sonMenus的区别在于 此函数对菜单的状态进行了判断
     * @return lists 
     */
    public function sonMenuModels()
    {
        $map = ['pid' => $this->id, 'status' => 0, 'is_hidden' => '0', 'is_deleted' => 0];
        $menuModels = $this->where($map)->order('weight desc')->select();
        return $menuModels;
    }

    /**
     * 获取当前菜单的菜单树（从根菜单开始，至本菜单结束）
     * @return lists MenuModel
     */
    public function getFatherMenuModleTree()
    {
        $tree = [];
        $MenuModel = $this;
        do {
            array_push($tree, $MenuModel);
            $MenuModel = $MenuModel->fatherMenuModel();
        } while ('' !== $MenuModel->getData('id'));
        return array_reverse($tree);
    }

    /**
     * 获取当前菜单树中的第二级菜单与第三级菜单
     * @return array MenuModel
     * @author  gaoliming
     */
    public function getSecondMenuModle()
    {
        $MenuModel = $this;

        //一级菜单
        if (0 === $MenuModel->pid) {
            //取出二级菜单
            return $MenuModel->sonMenuModels();
        }

        //二级菜单
        $FirstMenuModel = MenuModel::get($MenuModel->pid);
        if (0 === $FirstMenuModel->pid) {
            //取出二级菜单
            return $FirstMenuModel->sonMenuModels();
        }

        //三级菜单
        $FirstMenuModel = MenuModel::get($FirstMenuModel->pid);
        //取出二级菜单
        return $FirstMenuModel->sonMenuModels();
    }

    /**
     * 获取指定上级ID的菜单列表 
     * @param  int $pid 上级ID
     * @return lists      MenuModels
     */
    static public function getMenuModelsByPid($pid)
    {
        $map = [];
        $map['pid'] = $pid;
        $order = ['menu_type_name' => 'desc', 'weight' => 'desc', 'id' => 'desc'];
        $MenuModel = new MenuModel;
        return $MenuModel->where($map)->order($order)->select();
    }

    /**
     * 获取伪树状二维数组列表
     * @param  起始的上级ID  $pid         
     * @param  lists   &$resultTree 返回数组
     * @param  integer $Depth       深度
     * @param  object  $MenuModel   MenuModel
     * @return lists               MenuModel
     */
    static public function getTreeList($pid, $depth = 1, $unDepth = 0, &$MenuModel = null)
    {
        $result = array();
        $map        = [];
        $map['pid'] = $pid;
        $order      = ['menu_type_name' => 'desc', 'weight' => 'desc'];

        if (null == $MenuModel)
        {
            $MenuModel = new MenuModel;
        }

        $MenuModels = $MenuModel->where($map)->order($order)->select();
        foreach ($MenuModels as $key => $_MenuModel)
        {
            $_MenuModel->setDepth($unDepth);
            array_push($result, $_MenuModel);
            if ($depth > 1) {
                $result = array_merge($result, self::getTreeList($_MenuModel->getData('id'), $depth - 1, $unDepth + 1,  $MenuModel));
            }           
        }

        return $result;
    }


    /**
     * 获取根菜单列表
     * @return lists      MenuModels
     */
    static public function getRootMenuModels()
    {
        return self::getMenuModelsByPid(0);
    }


    /**
     * 获取可用的子菜单模型
     * @param    int                   $pid          父级ID
     * @param    string                   $menuTypeName 菜单类型
     * @return   lists                                 
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-13T08:55:26+0800
     */
    static public function getAvailableSonMenuModelsByPidMenuTypeName($pid, $menuTypeName)
    {
        // 找到当前用户组(每个用户只能有一个用户组)
        $currentFrontUserModel = UserModel::getCurrentFrontUserModel();
        $currentFrontUserGroupModel = $currentFrontUserModel->UserGroupModel();

        $map = ['pid' => $pid, 'status' => 0, 'is_hidden' => '0', 'menu_type_name' => $menuTypeName];
        $MenuModel = new MenuModel;
        $availableSonMenuModels = $MenuModel->order('weight desc')->where($map)->select();
        foreach ($availableSonMenuModels as $key => $MenuModel) {
            if (!$currentFrontUserGroupModel->isIndexAllowedByMenuModel($MenuModel))
            {
                unset($availableSonMenuModels[$key]);
            }
        }
        return $availableSonMenuModels;
    }

    /**
     * 显示是否隐藏
     * @param int  $value
     * @return string 
     * @author  gaoliming
     */
    public function getIsHiddenAttr($value)
    {
        $status = array(
            '0' => '是', 
            '1' => '一',
            );
        if ($value === 0) {
            return $status[0];
        } else {
            return $status[1];
        }
    }

    /**
     * 是否显示首页
     * @param int  $value
     * @return  string 
     * @author  gaoliming
     */
    public function getIsHomeAttr($value)
    {
        $status = array(
            '0' => '一',
            '1' => '是',
            );
        if ($value === 0) {
            return $status[0];
        } else {
            return $status[1];
        }
    }

    /**
     * return
     * 更新菜单权重
     * author liuxi
     */
    public function updateMenuWeightById($id,$weight)
    {
        if (!$id || !is_numeric($id)) {
            throw new Exception("ID不合法");
        }
        $data = array(
            'weight' => intval($weight),
            );
        return $this->where('id','=',$id)->find()->save($data);
    }
}