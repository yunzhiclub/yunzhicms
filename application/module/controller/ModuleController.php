<?php
namespace app\module\controller;
use think\Controller;
use app\model\BlockModel;               // 区块
use app\Common;
use app\model\BlockMenuModel;           // 

class ModuleController extends Controller
{
    protected $config = [];
    protected $filter = [];

    public function __construct(BlockModel $BlockModel, Request $request = null)
    {
        if (is_array($BlockModel->config))
        {
            $this->config = Common::configMerge($this->config, $BlockModel->config);
        }

        if (is_array($BlockModel->filter))
        {
            $this->filter = Common::configMerge($this->filter, $BlockModel->filter);
        }
        
        parent::__construct($request);
    }

    /**
     * 初始化，供Cx中position标签调用
     * @param  string $name 位置名字
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($name)
    {
        // 找出所有在当前position下的block
        $BlockModel = new BlockModel;
        $blockModels = $BlockModel->getActiveListsByPositionName($name);

        $resultHtml = '';
        // 依次进行渲染，拼接
        foreach ($blockModels as $blockModel)
        {
            $className = 'app\module\controller\\' . $blockModel->module_name . 'Controller';
            try 
            {
                // 实例化类 并调用
                $class = new $className($blockModel);
                $result = call_user_func([$class, 'fetchHtml']); 
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