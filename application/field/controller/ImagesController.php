<?php
namespace app\field\controller;

use think\Request;                                  // 请求

use app\Common;
use app\model\FieldDataImagesModel;                     // 多图片上传
use app\model\FieldDataImageModel;                      // 单图片上传

class ImagesController extends FieldController
{
    public function fetchHtml()
    {   
        $this->assign('token', Common::makeTokenByMCAData('field', 'Images', 'upload'));
        $this->assign('rand', rand(0,1000));
        return parent::fetchHtml();
    }

    static public function upload()
    {
        $result = ['status' => 'success'];
        // todo:讲解new self()与 new ImageController()的区别
        $FieldDataImageModel = new FieldDataImageModel;        
        $file = Request::instance()->file('Filedata');

        // 查看是否传入了文件信息
        if (null === $file) {
            $result = [
                'status' => 'error',
                'message'  => '传入的文件name值非Filedata,或未上传任何文件'
            ];
        } else {
            // 调用上传操作
            try {
                $result['data'] = $FieldDataImageModel->upload($file);
            } catch (\Exception $e) {
                $result = [
                    'status' => 'error',
                    'message'  => '上传文件发生错误，错误信息：' . $e->getMessage(),
                ];
            }
        }

        // 返回信息
        return json_encode($result);
    }
}