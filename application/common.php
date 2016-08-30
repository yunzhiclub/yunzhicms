<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app;
use think\Route;
use think\Db;
use app\model\MenuModel;

// 初始化
Common::init();

// 注册路由信息
Common::registerRouter();

class Common{

    /**
     * 注册路由信息
     * @param  array $menus 菜单列表
     * @return void        
     */
    static public function registerRouter()
    {
        // 查询菜单表
        $menus = self::reMakeLinkPath(Db::name('menu')->select());

        // 查询组件表
        $components = Db::name('component')->select();
        $components = self::changeListIndex($components, 'name');

        // 注册CURD路由信息 
        foreach ($menus as $menu)
        {   
            // 注册路由
            $componentName = $menu['component_name'];
            if (array_key_exists($componentName, $components))
            {
                $router = 'Component/' . $components[$componentName]['name'];

                // 如果是首页，则注册为普通路由
                if ((int)$menu['is_home'] === 1)
                {
                    $router .= '/index';
                    Route::rule('/', $router);
                } else {
                    // 非首页注册curd路由
                    Route::curd($menu['url'], $router);
                }
            }
        }
    }

    /**
     * 生成linkPath信息（即URL）
     * @param  lists &$menus 二级数组(menu)
     * @param  list $menu    菜单信息
     * @return string         拼接后的url信息
     */
    static public function makeLinkPath(&$menus, $menu)
    {
        // 将路由信息写入数组
        $linkPathArray = array();
        do {
            $pid = (int)$menu['pid'];
            array_push($linkPathArray, $menu['url']);
        } while ($pid !== 0 && $menu = $menus[$pid]);

        // 将数组进行反转后，转化为可用的字符串
        $linkPathArray = array_reverse($linkPathArray);
        return implode($linkPathArray, '/');
    }

    // 重新整理菜单中的linkPath, 使其具有上下级菜单的关系，以便重新注册路由
    static public function reMakeLinkPath($menus)
    {
        $menus = self::listToTree($menus);
        $menus = self::treeToList($menus);
        self::changeListIndex($menus);
        return $menus;
    }

    /**
     * 将树状数组转化为列表数组
     * @param  array  $tree  树状树组
     * @param  integer $i     转化为列表数组时，起始的depth值
     * @param  string  $child 子结点键值
     * @param  string  $depth 深度键值
     * @param  string  $order 排序方式
     * @param  array   &$list 返回的数组
     * @return array         列表数组
     */
    static public function treeToList($tree , $i = 0, $child = '_child', $depth = '_depth', $order='id', &$list = array())
    {
        if (is_array ( $tree )) {
            $refer = array ();
            //$tree = list_sort_by ( $tree, $order, $sortby = 'desc' );
            foreach ( $tree as $key => $value ) {
                $reffer = $value;
                $reffer[$depth] = $i;  
                $i++;

                if (isset ( $reffer [$child] )) 
                {
                    unset ( $reffer [$child] );
                    $list [] = $reffer;
                    self::treeToList ( $value [$child], $i, $child, $depth ,$order ,$list );
                }     
                else
                {
                    $list [] = $reffer;
                }
                $i--;
            }
            
        }
        return $list;
    }

     /**
     * 把返回的数据集转换成Tree
     *
     * @param array $list
     *          要转换的数据集
     * @param string $pid
     *          parent标记字段
     * @param string $level
     *          level标记字段
     * @return array
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    static public function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array ();
        if (is_array ( $list )) {
            // 创建基于主键的数组引用
            $refer = array ();
            foreach ( $list as $key => $data ) {
                    $refer [$data [$pk]] = & $list [$key];
            }
            foreach ( $list as $key => $data ) {
                // 判断是否存在parent
                $parentId = $data [$pid];
                if ($root == $parentId) {
                    $tree [] = & $list [$key];
                } else {
                    if (isset ( $refer [$parentId] )) {
                        $parent = & $refer [$parentId];
                        $parent [$child] [] = & $list [$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 改变数组的索引键值
     * @param  array &$lisft  数组
     * @param  string $key    新键值
     * @return array         
     */
    static public function changeListIndex(&$list, $key = 'id')
    {
        $arrRes = array();
        foreach($list as $k => $v)
        {
            $arrRes[$v[$key]] = $v;
        }
        $list = $arrRes;
        return $arrRes;
    }

    /**
     * 系统初始化
     * @return  
     */
    static public function init()
    {
        // 定义常量__ROOT__
        $root = dirname($_SERVER['SCRIPT_NAME']);
        if ($root === DS)
        {
            $root = '';
        }
        define('__ROOT__', $root);
    }
    
    /**
     * 合并配置信息
     * 将配置2中的配置信息，合并到配置1中
     * 示例：
     * config1:
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string '显示新闻的条数' (length=21)
     *     'type' => string 'text' (length=4)
     *     'value' => int 3
     *****************************************************************
     * 第一种形式：只改变value值
     * config2:
     * array (size=1)
     * 'count' => int 2
     *
     * @return
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string '显示新闻的条数' (length=21)
     *     'type' => string 'text' (length=4)
     *     'value' => int 2
     *****************************************************************
     * 第二种形式：改变其它值
     * array (size=1)
     * 'count' => 
     *   array (size=2)
     *     'description' => string 'hello' (length=5)
     *     'value' => string '4' (length=1)
     *
     * @return
     * array (size=1)
     * 'count' => 
     *   array (size=3)
     *     'description' => string 'hello' (length=5)
     *     'type' => string 'text' (length=4)
     *     'value' => string '4' (length=1)
     ******************************************************************    
     * @author panjie
     */
    static public function configMerge($config1, $config2)
    {
        if (!is_array($config1))
        {
            return array();
        }

        if (is_array($config2))
        {
            // 遍历config2
            foreach ($config2 as $key => &$config)
            {
                // 当key在config1中存在时，进行合并操作
                if (array_key_exists($key, $config1))
                {
                    // 按类型进行分类合并
                    if (is_array($config))
                    {
                        $config1[$key] = self::configMerge($config1[$key], $config);
                    } elseif (is_array($config1[$key])) {
                        $config1[$key]['value'] = $config;
                    } else {
                        $config1[$key] = $config;
                    }
                }
            }
        } else {
            
        }
        return $config1;
    }

    /**
     * 通过POST过来的数据信息，生成过滤器JSON配置信息
     * @param  array $postArray post过来的数据
     * array (size=3)
     *    'title' => 
     *      array (size=5)
     *        'name' => string 'title' (length=5)
     *        'type' => string 'String' (length=6)
     *        'function' => string 'substr' (length=6)
     *        'length' => string '30' (length=2)
     *        'ext' => string '...' (length=3)
     *    'href' => 
     *      array (size=3)
     *        'name' => string 'href' (length=4)
     *        'type' => string 'System' (length=6)
     *        'function' => string 'makeCurrentMenuReadUrl' (length=22)
     *    'date' => 
     *      array (size=4)
     *        'name' => string 'date' (length=4)
     *        'type' => string 'Date' (length=4)
     *        'function' => string 'format' (length=6)
     *        'dateFormat' => string 'Y-m-d' (length=5)
     * @return array            适用于存储到数据库的JSON信息
     * array (size=3)
     *   'title' => 
     *     array (size=3)
     *       'type' => string 'String' (length=6)
     *       'function' => string 'substr' (length=6)
     *       'param' => 
     *         array (size=2)
     *           'length' => string '30' (length=2)
     *           'ext' => string '...' (length=3)
     *   'href' => 
     *     array (size=3)
     *       'type' => string 'System' (length=6)
     *       'function' => string 'makeCurrentMenuReadUrl' (length=22)
     *       'param' => 
     *         array (size=0)
     *           empty
     *   'date' => 
     *     array (size=3)
     *       'type' => string 'Date' (length=4)
     *       'function' => string 'format' (length=6)
     *       'param' => 
     *         array (size=1)
     *           'dateFormat' => string 'Y-m-d' (length=5)
     *
     */
    static public function makeFliterArrayFromPostArray($postArray)
    {
        $filter = array();
        foreach ($postArray as $value)
        {
            $key = $value['name'];
            $result             = array();
            $result['type']     = $value['type'];
            $result['function'] = $value['function'];
            unset($value['name']);
            unset($value['type']);
            unset($value['function']);

            $result['param']    = $value;
            
            $filter[$key] = $result;
        }
        return $filter;
    }

    /**
     * 获取控制器名称
     * @param  string $calledClass 
     *         app\block\controller\BreadCrumbController
     * @return string              
     *         BreadCrumb
     */
    static public function getControllerName($calledClass)
    {
        $calledClassArray = explode('\\', $calledClass);
        $calledClass = array_pop($calledClassArray);
        return substr($calledClass, 0, -strlen('Controller'));
    }
}

