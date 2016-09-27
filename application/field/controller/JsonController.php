<?php
namespace app\field\controller;

use think\Request;                                  // 请求

use app\Common;
use app\model\FieldDataJsonModel;                    // json模型
class JsonController extends FieldController
{
    public function edit()
    {
        // 增加token,用于字段个数的修改
        $token = $this->FieldDataXXXModel->makeToken('addSubCount');
        $this->assign('token', $token);

        return $this->fetch();
    }

    /**
     * 添加1个或是减少一个子元素
     * @param    array                    $data 传入值
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T12:13:10+0800
     */
    static public function addSubCount($data = [])
    {
        // 获取请求信息
        $Request = Request::instance();
        $param = $Request->param();

        // 获取当前数据字段对象
        $FieldDataJsonModel = FieldDataJsonModel::get($data);
        $array = json_decode($FieldDataJsonModel->getData('value'), true);

        // 判断是添加还是减小
        if (array_key_exists('type', $param) && $param['type'] === 'add') {
            array_push($array, ''); 
        } else {
            array_pop($array);
        }

        // 保存数据
        $value = json_encode($array);
        $FieldDataJsonModel->setData('value', $value);
        $FieldDataJsonModel->save();

        // 返回到调用前的url
        $Object = new self();
        return $Object->success('操作成功', $Request->server('HTTP_REFERER'));
    }
}