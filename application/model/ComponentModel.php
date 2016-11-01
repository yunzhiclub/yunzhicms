<?php
namespace app\model;

class ComponentModel extends ModelModel
{
    protected $pk           = 'name';
    private $config         = null;         // 配置
    private $filter         = null;         // 过滤器
    private $route          = null;         // 路由
    private $sampleRoute    = null;         // 简单路由

    static public function getCurrentComponent($component)
    {
        $arr = explode('\\', $component);
        $componentName = array_pop($arr);
        $componentName = substr($componentName, 0, -strlen('Controller'));
        $map = ['name'=>$componentName];
        return ComponentModel::get($map);
    }

    public function getRoute() 
    {
        if (null === $this->route) {
            $this->route = [];

            // 本看是否存在其它路由参数，有的话，依次进行注册
            $routeFilePath = realpath(APP_PATH . 
                'component' . DS . 
                'route' . DS . 
                $componentName . 'Route.php');
            if (false !== $routeFilePath) {
                $this->route = include $routeFilePath;
            }
        }

        return $this->route;
    }

    /**
     * 获取简单路由
     * @return   [type]                   [description]
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T16:41:22+0800
     */
    public function getSampleRoute()
    {
        if (null === $this->sampleRoute) {
            $this->sampleRoute = [];
            $routes = $this->getRoute();
            foreach ($routes as $key => $route) {
                $this->sampleRoute[$key] = $route['value'];
            }
        }

        return $this->sampleRoute;
    }

    /**
     * 读取相关配置文件后，得出配置信息
     * @return array 
     */
    public function getConfig()
    {
        if (null === $this->config) {
            $configFilePath = APP_PATH . 
                'component' . DS . 
                'config' . DS .
                $this->getData('name') . 'Config.php';
            $configFilePath = realpath($configFilePath);
            if (false === $configFilePath) {
                $this->config = [];
            } else {
                $this->config = include $configFilePath;
            }
        }
        
        return $this->config;
    }

    /**
     * 读取相关配置文件后，得出配置信息
     * @return array 
     */
    public function getFilter()
    {
        if (null === $this->filter) {
            $filterFilePath = APP_PATH . 
                'component' . DS . 
                'filter' . DS .
                $this->getData('name') . 'Filter.php';
            $filterFilePath = realpath($filterFilePath);
            if (false === $filterFilePath) {
                $this->filter = [];
            } else {
                $this->filter = include $filterFilePath;
            }
        }

        return $this->filter;
    }

    /**
     * 获取该组件类型的菜单
     * @param  string $name 组建名
     * @return array       
     * @author chuhang 
     */
    public function getAllMenuModels($name)
    {
        $map['component_name'] = $name;
        $MenuModel = new MenuModel;
        $result = $MenuModel->where($map)->select();
        return $result;
    }
}