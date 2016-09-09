<?php
return [
    'js'    => [
        'title'         => 'js第三方类库',
        'description'   => '相对于public的相对路径, 以"/"开头。多链接 使用 "," 相隔',
        'type'          => 'text',
        'value'         => '/lib/uploadify/jquery.uploadify.min.js'
    ],
    'css'   => [
        'title'         => 'css第三方类库',
        'description'   => '相对于public的相对路径, 以"/"开头。多链接 使用 "," 相隔',
        'type'          => 'text',
        'value'         => '/lib/uploadify/uploadify.css'
    ],
    'uploadPath'   => [
        'title'         => '上传文件夹',
        'description'   => '相对于public的相对路径, 以"/"开头',
        'type'          => 'text',
        'value'         => '/upload',
    ],
    'size'          => [
        'title'         => '最大上传文件大小B', 
        'description'   => '除此设置以外，还需要对apache的max_upload_size及max_post_size进行设置',
        'type'          => 'text',
        'value'         => '2048000'
    ],
    'ext'           => [
        'title'         => '允许上传文件的扩展名',
        'description'   => '支持多个扩展名，使用 , 相隔',
        'type'          => 'text',
        'value'         => 'png,jpg,jpeg,gif,bmp,doc,pdf',
    ],
];