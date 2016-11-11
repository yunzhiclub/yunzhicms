<?php
namespace app\field\controller;

use think\Request;                                  // 请求

use app\Common;
use app\model\FieldDataImagesModel;                             // 多图片上传
use app\model\FieldDataAttachmentModel;                         // 附件上传

class ImagesController extends FieldController
{
    public function edit()
    {   
        $this->assign('token', $this->FieldDataXXXModel->makeToken('upload'));
        $this->assign('addSubToken', Common::makeTokenByMCAData('field', 'Images', 'addSubCount', ['id' => $this->FieldDataXXXModel->getData('id')]));
        return $this->fetch() . $this->fetch('editCss') . $this->fetch('editJs');
    }

    /**
     * 上传，直接调用的FiledDataImage中的上传。
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-09T13:57:50+0800
     */
    static public function upload()
    {
        $result = ['status' => 'success'];
        // todo:讲解new self()与 new ImageController()的区别
        $FieldDataAttachmentModel = new FieldDataAttachmentModel;

        //取出images中的配置信息
        $ImagesModel = new FieldDataImagesModel();
        $config      = $ImagesModel->getConfig();        
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
        $FieldDataImagesModel = FieldDataImagesModel::get($data);
        $array = json_decode($FieldDataImagesModel->getData('value'), true);

        // 判断是添加还是减小
        if (array_key_exists('type', $param) && $param['type'] === 'add') {
            if (!array_search('', $array)) {
                array_push($array, ''); 
            }
            
        } else {
            array_pop($array);
        }

        // 保存数据
        $value = json_encode($array);
        $FieldDataImagesModel->setData('value', $value);
        $FieldDataImagesModel->save();

        // 返回到调用前的url
        $Object = new self();
        return $Object->success('操作成功', $Request->server('HTTP_REFERER'));
    }
}