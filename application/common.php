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
use think\Request;
use think\Session;
use app\model\MenuModel;
use app\model\UserModel;

// 初始化
Common::init();
Route::rule('news/:id', 'component/ContentList/read', 'GET');
class Common{
    static protected $token = [];       // token 用于安全验证
    static protected $css   = [];       // css 用于模板链接css文件
    static protected $js    = [];       // js 用于模板链接js文件

    /**
     * 系统初始化
     * @return  
     */
    static public function init()
    {
        // 定义全局路径变量
        self::definePath();

        // 定义变量过滤。在获取变量值时，禁用input()助手函数
        Request::instance()->filter('htmlspecialchars');

        // 注册路由信息
        self::registerRouter();
    }

    /**
     * 定义路径
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T12:28:14+0800
     */
    static public function definePath()
    {
        // 定义常量__ROOT__
        $root = dirname($_SERVER['SCRIPT_NAME']);
        if ($root === DS)
        {
            $root = '';
        }
        define('__ROOT__', $root);

        // 定义常量PUBLIC_PATH
        $publicPath = realpath(ROOT_PATH) . DS . 'public';
        define('PUBLIC_PATH' , $publicPath);
    }

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
        
        // 由于路由需要由长到短进行注册，在这，我们先给一个缓存
        $cacheRoutes = [];
        
        foreach ($menus as $menu) {
            // 注册路由
            $componentName = $menu['component_name'];
            if (array_key_exists($componentName, $components))
            {
                // 本看是否存在其它路由参数，有的话，依次进行注册
                $routeFilePath = realpath(APP_PATH . 
                    'component' . DS . 
                    'route' . DS . 
                    $componentName . 'Route.php');

                // 按路由配置文件注册路由：http://www.kancloud.cn/manual/thinkphp5/118030
                if (false !== $routeFilePath) {
                    $routes = include $routeFilePath;
                    
                    foreach ($routes as $action => &$_route) {
                        $value      = $_route['value'];
                        $route      = '';
                        $type       = '*';
                        $option     = []; 
                        $pattern    = [];

                        if (isset($value[0])) {
                            $rule = $menu['url'] . $value[0];
                        } else {
                            continue;
                        }

                        // 拼接路由
                        $route = 'component/' . $componentName . '/' . $action;

                        if (isset($value[1])) {
                            $type = $value[1];
                        }

                        if (isset($value[2])) {
                            if (is_array($value[2])) {
                                $option = $value[2]; 
                            }
                        }

                        if (isset($value[3])) {
                            if (is_array($value[3])) {
                                $pattern = $value[3]; 
                            }
                        }

                        // 按不同的长度，分别进行路由缓存
                        $length = substr_count($rule, '/');
                        if (!isset($cacheRoutes[$length])) {
                            $cacheRoutes[$length] = [];
                        }
                        array_push($cacheRoutes[$length], [$rule, $route, $type, $option, $pattern]);
                    }
                }
            }
        }

        // 对路由缓存进行由长到短的排序
        ksort($cacheRoutes);
        $cacheRoutes = array_reverse($cacheRoutes);
        foreach ($cacheRoutes as $cacheRoute) {
            foreach ($cacheRoute as $route) {
                //调用路由注册
                Route::rule($route[0], $route[1], $route[2], $route[3], $route[4]);
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

    /**
     * 根据用户当前访问的URL信息，生成 编辑URL
     * 当前访问URL为：http://127.0.0.1/yunzhicms/public/news/school/1.html?p=2
     * 则生成的URL为：http://127.0.0.1/yunzhicms/public/news/school/1/edit.html?p=2
     * @return string 
     * @author panjie
     */
    static public function getEditUrl()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return str_replace('.html', '/edit.html', $requestUri);
    }

    /**
     * 生成创建URL地址
     * @return string 
     * @author panjie
     */
    static public function getCreateUrl()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return str_replace('.html', '/create.html', $requestUri);
    }

    /**
     * 生成子地址，用于同一组件下，生成下一级路由
     * @param    string                   $subAction 
     * @return   String
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-13T08:04:12+0800
     */
    static public function makeSubUrl($subAction = '')
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return str_replace('.html', '/' . $subAction . '.html', $requestUri);
    }

    /**
     * 生成 保存 URL地址
     * @return string 
     * @author panjie
     */
    static public function getSaveUrl()
    {
        $requestUris = explode('/', $_SERVER['REQUEST_URI']);
        array_pop($requestUris);
        return implode('/', $requestUris) . '.html'; 
    }

    /**
     * 生成更新地址
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T09:21:00+0800
     */
    static public function getUpdateUrl()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return str_replace('/edit', '', $requestUri);
    }

    /**
     * 检测当前用户触发的权限
     * @return   bool                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T12:23:44+0800
     */
    static public function checkAccess()
    {
        
    }

    /**
     * 生成基于当前菜单URL的正确的，可直接显示在前台，被用户点击触发的URL
     * @param    string                   $route 传入的路由地址信息
     * @return   string                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-13T11:08:05+0800
     */
    static public function url($route = '')
    {
        $url = MenuModel::getCurrentMenuModel()->getData('url');
        return url('@' . $url . $route);
    }


    /**
     * 通过token获取对应的menuModel
     * @param    string                   $token 
     * @return   MenuModel                
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T13:26:23+0800
     */
    static public function getMenuModelByToken(&$token)
    {
        $keys = self::getKeysByToken($token);
        $menuId = $keys[0];
        return MenuModel::get(['id'=>$menuId]);
    }

    /**
     * 通过token获取 token 对应的action
     * @param    string                   &$token 
     * @return   string                           
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T13:56:40+0800
     */
    static public function getActionByToken(&$token)
    {
        $keys = self::getKeysByToken($token);
        return $keys[1];
    }

    /**
     * 通过token 获取 token 对应的键值 比如 将3_index 转化为 ['3', 'index']
     * 表示 menu_id = 3 , action = 'index' 
     * @param    string                   &$token 
     * @return   array                           ['menu_id', 'action']
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T13:56:59+0800
     */
    static public function getKeysByToken(&$token)
    {
        $keys = array();
        $tokens = Session::get('tokens');
        if (null !== $tokens) {
            $key = array_search($token, $tokens);
            if (false !== $key) {
                $keys = explode('_', $key);
            }
        }
        return $keys;
    }

    /**
     * 检测传入的token是否有效
     * @param    string                   &$token 
     * @return   bool                           
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T13:59:00+0800
     */
    static public function checkTokenisEffective(&$token)
    {
        $keys = self::getKeysByToken($token);
        if (empty($keys))
        {
            return false;
        } else {
            return true;
        }
    }


    /**
     * 检测当前用户是否拥有 传入的token对应的action及 菜单权限
     * @param    string                   &$token 
     * @return   bool                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T13:59:21+0800
     */
    static public function checkIsAllowedByToken(&$token)
    {
        if (!self::checkTokenisEffective($token)) {
            return false;
        }

        $MenuModel = self::getMenuModelByToken($token);
        $action = self::getActionByToken($token);
        $access = self::getAccessByAction($action);

        $currentFrontUserModel = UserModel::getCurrentFrontUserModel();
        if (!$currentFrontUserModel->getUserGroupModel()->getAccessByLCURDValue($MenuModel, $access)) {
            return false;
        }

        return true;
    }

    /**
     * 生成token值，供区块、插件、字段编辑时调用。解决在区块、插件、字段编辑时无法进行权限判断而引发的安全问题
     * @param    string                   $module     模块名
     * @param    string                   $controller 控制器名
     * @param    string                   $action     触发器名
     * @param    array                    $data       当前token缓存的数据
     * @return   string                               经过sha1后的序列
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-13T08:00:35+0800
     */
    static public function makeTokenByMCAData($module, $controller, $action, $data = [])
    {
        // 取出当前token
        $tokens = Session::get('tokens');
        if (null === $tokens) {
            $tokens = [];
        }
        
        // 生成token并缓存数据
        $token = sha1($module . $controller . $action . microtime() . rand(1,10000) . config('token_suffix'));
        $tokens[$token] = ['module' => $module, 'controller' => $controller, 'action' => $action, 'data' => $data];

        // 存token
        Session::set('tokens', $tokens);
        
        // 返回生成并且注册的token
        return $token;
    }

    /**
     * 清空tokens
     * @return   null                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-14T17:02:32+0800
     */
    static public function clearTokens()
    {
        Session::set('tokens', null);
    }

    /**
     * 通过token值，获取token中保存的信息
     * @param    string                   &$token 
     * @return   array                           
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T08:04:01+0800
     */
    static public function getInfoByToken(&$token)
    {
        $tokens = Session::get('tokens');

        if (null !== $tokens && array_key_exists($token, $tokens)) {
            return $tokens[$token];
        } else {
            return null;
        }
    }


    /**
     * 添加CSS引用路径
     * @param    string                   $key      键值 模块名_控制器名
     * @param    string                  $linkPath 相对于public的绝对路径。比如:lib/css/text.css
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T07:42:49+0800
     */
    static public function addCss($linkPath)
    {   
        $linkPaths = explode(',', $linkPath);
        foreach ($linkPaths as $_linkPath) {
            if (!in_array($_linkPath, self::$css))
            {
                array_push(self::$css, $_linkPath);
            }
        }

        return self::$css;
    }

    /**
     * 添加js引用路径
     * @param    string                   $key      键值 模块名_控制器名
     * @param    [type]                   $linkPath 相对于public的绝对路径。比如:lib/js/text.js
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T07:46:38+0800
     */
    static public function addJs($linkPath)
    {   
        $linkPaths = explode(',', $linkPath);
        foreach ($linkPaths as $_linkPath) {
            if (!in_array($_linkPath, self::$js))
            {
                array_push(self::$js, $_linkPath);
            }
        }
        
        return self::$js;
    }

    /**
     * 获取CSS路径信息
     * @return   array               
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T07:49:09+0800
     */
    static public function getCss()
    {
        return self::$css;
    }

    /**
     * 获取当前页面所有的css链接
     * @return   string                   拼接后的路径信息
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T08:44:33+0800
     */
    static public function getCssLinks()
    {
        $css = self::getCss();
        $html = '';
        foreach ($css as $_css)
        {
            $html .= '
            <link href="'. __ROOT__ . $_css . '" rel="stylesheet">
            ';
        }
        return $html;
    }

    /**
     * 获取js路径信息
     * @return   array                 
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T07:49:50+0800
     */
    static public function getJs()
    {
        return self::$js;
    }

    /**
     * 获取当前页面所有的js链接
     * @return   string                   拼接后的路径信息
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T08:44:33+0800
     */
    static public function getJsLinks()
    {
        $js = self::getJs();
        $html = '';
        foreach ($js as $_js)
        {
            $html .= '
            <script type="text/javascript" src="'. __ROOT__ . $_js . '"></script>
            ';
        }
        return $html;
    }

}

