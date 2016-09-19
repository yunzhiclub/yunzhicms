<?php
namespace app\field\controller;

use app\Common;
use app\model\FieldDataImageModel;              // 上传使用的为image扩展字段的信息
use think\Request;

class BodyController extends FieldController
{
    /**
     * 文件上传，供api接口进行动态调用
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T10:49:48+0800
     */
    static public function upload()
    {
        $result = 'error|';

        // todo:讲解new self()与 new ImageController()的区别
        $FieldDataImageModel = new FieldDataImageModel;        
        $file = Request::instance()->file('Filedata');
    
        // 查看是否传入了文件信息
        if (null === $file) {
            $result .= '传入的文件name值非Filedata,或未上传任何文件';
        } else {
            // 调用上传操作
            try {
                $result = $FieldDataImageModel->upload($file)->getUrl();
            } catch (\Exception $e) {
                $result .= '上传文件发生错误，错误信息：' . $e->getMessage();
            }
        }

        // 返回信息
        return $result;
    }

    public function edit()
    {
        $this->assign('token', Common::makeTokenByMCAData('field', 'Body', 'upload'));
        return parent::renderAction('edit');
    }
}