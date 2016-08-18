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

// 查询菜单表，并整理出上下级关系
$menus = Common::reMakeLinkPath(Db::name('menu')->where('is_hidden', 0)->select());

// 查询组件表
$components = Db::name('component')->select();
$components = Common::changeListIndex($components, 'name');

// 注册REST路由信息 
foreach ($menus as $menu)
{   
    // 将路由信息写入数组
    $temMenu = $menu;
    $linkPathArray = array();
    do {
        $pid = (int)$temMenu['pid'];
        array_push($linkPathArray, $temMenu['url']);
    } while ($pid !== 0 && $temMenu = $menus[$pid]);

    // 将数组进行反转后，转化为可用的字符串
    $linkPathArray = array_reverse($linkPathArray);
    $linkPath = implode($linkPathArray, '/');

    // 注册路由
    $componentName = $menu['component_name'];
    if (isset($components[$componentName]))
    {
        $router = 'Component/' . $components[$componentName]['name'];
        Route::resource($linkPath, $router);
    }
}


// 为本文件的一些方法提供一个基类供使用
class Common{

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
}