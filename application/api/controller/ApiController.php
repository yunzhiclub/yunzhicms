<?php
namespace app\api\controller;
use app\Common;
use think\Request;
/**
 * api 统一处理外部请求
 */
class ApiController
{
    /**
     * index 触发器，负责对数据进行转发
     * @param    string                   $token 访问令牌
     * @return                             
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T09:21:07+0800
     */
    public function indexAction($token)
    {
        // 判断token是否正确
        if (!$info = Common::getInfoByToken($token)) {
            
            // todo 根据不同的类型，返回不同类型的错误信息
            return 'Token is incorrect!';
        }

        // 根据返回，取回模块、控制器、触发器信息
        $module     = $info['module'];
        $controller = $info['controller'];
        $action     = $info['action'];
        $data       = $info['data'];

        // 接接要调用的类名
        $className  = '\app\\' . $module . '\controller\\' . $controller . 'Controller';

        // 生成当token时的用户触发的menuId及action
        return call_user_func_array([$className, $action], [$data]);
    }
}