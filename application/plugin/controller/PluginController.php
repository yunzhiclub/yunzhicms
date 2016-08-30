<?php
namespace app\plugin\controller;
use think\Controller;
use app\model\PluginModel;

/**
 * 插件管理
 */
class PluginController extends Controller
{
    /**
     * 初始化，供Cx中position标签调用
     * @param  string $name 位置名字
     * @param object $object 由V层传入的对象
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($name, $object = null)
    {
        // 找出所有在当前position下的block
        $PluginModel = new PluginModel;
        $pluginModels = $PluginModel->getActiveListsByPositionName($name);

        $resultHtml = '';
        
        // 依次进行渲染，拼接
        foreach ($pluginModels as $pluginModel)
        {
            $className = 'app\plugin\controller\\' . $pluginModel->plugin_type_name . 'Controller';
            try 
            {
                // 实例化类 并调用
                $class = new $className($blockModel);
                $result = call_user_func_array([$class, 'fetchHtml'], [$object]); 
                if ($result)
                {
                    $resultHtml .= $result;
                }
            } catch(\Exception $e) {
                if (config('app_debug'))
                {
                    throw $e;
                }
            } 
        }

        // 返回拼接后的字符串
        echo $resultHtml;
    }
}