<?php
namespace app\field\controller;
use app\Common;
USE think\Request;

class ImageController extends FieldController
{
    private $uploadPath;                 // 上传文件夹（相对于服务器的根目录）
    /**
     * 文件上传，供api接口进行动态调用
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-06T10:49:48+0800
     */
    static public function upload()
    {
        // todo:讲解new self()与 new ImageController()的区别
        $ImageController = new self();
        return $ImageController->_upload();
    }


    private function _upload()
    {
        $file = Request::instance()->file('Filedata');
        $info = $file->move($this->getUploadPath());
        var_dump($info);

        // $info = $file->move(ROOT_PATH)
    }

    public function getUploadPath()
    {
        if (null === $this->uploadPath) {
            if (isset($this->getConfig['uploadPath'])) {
                $uploadPath = $this->getConfig['uploadPath'];
            } else {
                $uploadPath = '/upload';
            }

            $this->uploadPath = PUBLIC_PATH . $uploadPath;
        }

        return $this->uploadPath;
    }


    public function makeToken()
    {
        return Common::makeTokenByMCA('field', 'Image', 'upload');
    }
}