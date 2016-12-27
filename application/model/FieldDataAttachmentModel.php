<?php
namespace app\model;
use app\Common;
use think\File;
/**
 * 附件字段
 */
class FieldDataAttachmentModel extends FieldModel
{
    private $uploadPath   = null;               // 上传路径
    private $url          = null;               // URL
    protected $token      = null;               // token 

    /**
     * 上传文件
     * @param    think\File                     $file 文件对象，继承SplFileObject类
     * @return   Object                         $this
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T10:45:52+0800
     */
    public function upload(File &$file, $config = [])
    {
        // 配置规则初始化
        $rule = [];
        $config = array_merge($this->getSimpleConfig(), $config);

        // 文件大小
        if (array_key_exists('size', $config)) {
            $rule['size'] = $config['size'];
        }

        // 文件类型MIME
        if (array_key_exists('type', $config)) {
            $rule['type'] = $config['type'];
        }

        // 扩展名
        if (array_key_exists('ext', $config)) {
            $rule['ext'] = $config['ext'];
        }
        
        // 对文件进行检测
        if (!$file->check($rule)) {
            throw new \Exception("Upload file error:" . $file->getError(), 1);
        }

        // 检测文件是否存在
        $map = [];
        $map['sha1'] = $sha1 = $file->sha1();
        $map['md5'] = $md5 = $file->md5();

        // 使用new self() 避免了其它类继承本类后，仍然可以对应找到正确的数据表名。
        $static = new static();
        $data = $static::get($map);

        // 文件存在，则去除field_id 及key_id后复制一份进入数据库
        if ('' !== $data->getData('id')) {
            $static->data = $data->getData();
            $static->setData('field_id', 0);
            $static->setData('key_id', 0);
            unset($static->data['id']);

        // 文件不存在，则执行upload 操作
        } else { 
            $info = $file->move($static->getUploadPath());
            // $static->setData('user_name', ); todo:取当前用户信息
            $static->setData('name', $info->getInfo('name'));
            $static->setData('save_name', $info->getSaveName());
            $static->setData('ext',   $info->getExtension());
            $static->setData('sha1',  $sha1);
            $static->setData('md5',   $md5);
            $static->setData('size',  $info->getInfo('size'));
            $static->setData('mime',  $info->getMime());
        }

        // 新建数据，并将当前对象返回
        $static->save();
        return $static;
    }

    /**
     * 获取文件上传的路径设置(相对于服务器实际路径)
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T10:45:20+0800
     */
    public function getUploadPath()
    {
        if (null === $this->uploadPath) {
            if (isset($this->getConfig()['uploadPath'])) {
                $uploadPath = $this->getConfig()['uploadPath']['value'];
            } else {
                $uploadPath = '/upload';
            }

            $this->uploadPath = PUBLIC_PATH . $uploadPath;
        }

        return $this->uploadPath;
    }


    /**
     * 获取url (相对于站点的路径)
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T13:58:16+0800
     */
    public function getUrl()
    {
        if (null === $this->url) {
            $this->url = __ROOT__ . $this->getConfig()['uploadPath']['value'] . '/' . $this->getData('save_name');
        }

        return $this->url;
    }

    /**
     * json数据，进行json_encode时，将自动处发该方法，并将其返回值进行序列化
     * @return   array                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T13:58:56+0800
     */
    public function jsonSerialize() 
    {
        $data = $this->getData();
        $data['url'] = $this->getUrl();
        return $data;
    }

    /**
     * 更新扩展字段
     * @param    int                   $fieldId 关联字段id
     * @param    int                   $keyId   关联关键字id
     * @param    |||                   $id      关键字
     * @return    更新的id值                          
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-07T15:21:43+0800
     */
    static public function updateList($fieldId, $keyId, $id)
    {
        $static = new static();
        $Object = $static::get(['id' => $id]);
        if ( '' !== $Object->getData('id')) {
            // 如果存在历史信息，先删除历史信息
            $oldObject = $static::get(['field_id' => $fieldId, 'key_id' => $keyId]);
            if ('' !== $oldObject && ($oldObject->getData('id') !== $Object->getData('id'))) {
                $oldObject->delete();
            }

            // 更新当前数据
            $Object->setData('field_id', $fieldId);
            $Object->setData('key_id', $keyId);
            return $Object->save();
        }
    }
}

