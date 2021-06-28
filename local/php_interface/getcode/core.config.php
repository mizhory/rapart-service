<?php
/**
 * @about GetCode 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 */
define ('CORE_CONFIG_INCLUDED', TRUE);

define ('LOCAL_DIR', $_SERVER['DOCUMENT_ROOT'] . 'local/');
define ('GC_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define ('INCLUDE_DIR', GC_DIR . 'include/');
define ('CONFIG_DIR', GC_DIR . 'config/');

$files_autoload = [
    GC_DIR . 'autoloader.php',
    INCLUDE_DIR . 'assets.php',
    INCLUDE_DIR . 'handler.php',
    CONFIG_DIR . 'config.autoload.php'
];

foreach($files_autoload as $k=>$file) {
    if(file_exists($file))
        require_once $file;
}