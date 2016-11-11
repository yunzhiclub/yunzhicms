<?php
namespace app\field\controller;

use app\Common;
use think\Request;

use app\model\FieldDataAttachmentModel;

class AttachmentController extends FieldController
{
    public function index()
    {
        return $this->fetch();
    }

    public function edit()
    {
        $this->assign('uploadToken', $this->FieldDataXXXModel->makeToken('upload'));
        $this->assign('deleteToken', $this->FieldDataXXXModel->makeToken('delete'));
        return $this->fetch() . $this->fetch('editJs');
    }

    /**
     * 删除 静态方法为api调用
     * @param    array                    $data 
     * @return                            
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-26T09:28:24+0800
     */
    static public function delete($data = [])
    {
        if (!isset($data['id'])) {
            return 'Data error. The token do not assign Id for Attachment';
        }

        $FieldDataAttachmentModel = FieldDataAttachmentModel::get($data['id']);
        if ('' !== $FieldDataAttachmentModel->getData('id')) {
            $FieldDataAttachmentModel->delete();
            return 'Data delete success';
        } else {
            return 'The record not exist or Is deleted!';
        }
    }

    static public function upload($data = [])
    {
        $result = ['status' => 'success'];
        // todo:讲解new self()与 new ImageController()的区别
        $FieldDataAttachmentModel = new FieldDataAttachmentModel;        
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
                $result['data'] = $FieldDataAttachmentModel->upload($file, $config);
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