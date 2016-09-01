<?php
namespace app\model;

class ComponentModel extends ModelModel
{
    protected $pk       = 'name';
    private $config     = null;
    private $filter     = null;     

    static public function getCurrentComponent($component)
    {
        $arr = explode('\\', $component);
        $componentName = array_pop($arr);
        $componentName = substr($componentName, 0, -strlen('Controller'));
        $map = ['name'=>$componentName];
        return ComponentModel::get($map);
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
}