<?php
namespace app\field\controller;

use app\Common;
use think\Request;

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
        return parent::renderAction('edit');
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
        return 'hello';
    }

    static public function upload($data = [])
    {
        $Object = new self();
    }


}