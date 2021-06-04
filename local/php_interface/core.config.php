<?php
/**
 * @about AllSun-Integration 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 */
define ('CORE_CONFIG_INCLUDED', TRUE);

define ('LOCAL_DIR', $_SERVER['DOCUMENT_ROOT'] . 'local/');
define ('ALLSUN_DIR', LOCAL_DIR . 'php_interface/allsun/');
define ('INCLUDE_DIR', ALLSUN_DIR . 'include/');
define ('CONFIG_DIR', ALLSUN_DIR . 'config/');

$files_autoload = [
    ALLSUN_DIR . 'autoload.php',
    INCLUDE_DIR . 'assets.php',
    INCLUDE_DIR . 'handler.php',
    CONFIG_DIR . 'config.autoload.php'
];

foreach($files_autoload as $k=>$file) {
    if(file_exists($file))
        require_once $file;
}