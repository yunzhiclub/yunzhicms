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
        if (!$tokenKey = Common::getKeyByToken($token)) {
            
            // todo 根据不同的类型，返回不同类型的错误信息
            return 'Token is incorrect!';
        }

        // 根据token 调用对应的方法
        $tokenKeys  = explode('_', $tokenKey);
        $moudle     = $tokenKeys[0];
        $controller = $tokenKeys[1];
        $action     = $tokenKeys[2];

        // 接接要调用的类名
        $className  = '\app\\' . $moudle . '\controller\\' . $controller . 'Controller';

        // 生成当token时的用户触发的menuId及action
        return call_user_func([$className, $action]);
    }
}