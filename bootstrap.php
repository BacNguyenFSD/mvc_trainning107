<?php
define('_DIR_ROOT', __DIR__);

//Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}

// echo $_SERVER['DOCUMENT_ROOT'];
// echo '<br/>';
// echo _DIR_ROOT;

// $folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
// echo $folder;

$web_root = $web_root.'/php_unicode/PHP_advanced/Module5/mvc_trainning_107';
define('_WEB_ROOT', $web_root);

/**
 * Tự động load config
 */
$config_dir = scandir('configs');
if (!empty($config_dir)) {
    foreach ($config_dir as $item) {
        if ($item !='.' && $item!='..' && file_exists('configs/'.$item)) {
            require_once 'configs/'.$item;
        }
    }
}


require_once 'core/Route.php';//Load Route Class
require_once 'app/App.php';//Load app


if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);

    if (!empty($db_config)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}

require_once 'core/Model.php';//Load Model

require_once 'core/Controller.php';//Load base controller

require_once 'core/Request.php';//Load Request

require_once 'core/Response.php';//Load Response
