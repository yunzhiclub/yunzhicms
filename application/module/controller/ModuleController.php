<?php
namespace app\module\controller;

use think\Controller;

use app\Common;
use app\model\BlockModel;               // 区块 模型
use app\model\BlockMenuModel;           // 区块-菜单 模型
use app\model\MenuModel;                // 菜单模型

class ModuleController extends Controller
{
    protected $config = null;
    protected $filter = null;
    protected $currentMenuModel = null;


    public function __construct(BlockModel $BlockModel, Request $request = null)
    {
        // 取配置过滤器信息
        $this->config = $BlockModel->getConfig();;
        $this->filter = $BlockModel->getFilter();

        // 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();
        parent::__construct($request);

        // 送过滤器至V层
        $this->assign('filter', $this->filter);
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