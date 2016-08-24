<?php
$config = [
         
        'menu_type_name'=>['value' => 'main', 'title' => '菜单类型', 'description' => '菜单类型', 'type' => 'text'],
        'id' => ['value' => 'mu-menu', 'title' => '']
    ];
    $config = json_encode($config);
    var_dump(strlen($config));
    var_dump($config);