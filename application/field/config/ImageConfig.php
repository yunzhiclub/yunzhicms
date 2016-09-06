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
];