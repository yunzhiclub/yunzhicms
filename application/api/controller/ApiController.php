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
        $tokenKeys = explode('_', $tokenKey);
        $className = '\app\\' . $tokenKeys[0] . '\controller\\' . $tokenKeys[1] . 'Controller';
        $param = ['menuId' => $className[3], 'action' => $className[4]];
        return call_user_func_array([$className, $tokenKeys[2]], $param);
    }
}