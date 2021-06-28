<?php
/**
 * @about GetCode 2021 - Copyright AllRight Reserved
 * @author CEO Kokurkin-German
 */

$config_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core.config.php';

if(file_exists($config_file))
    require_once $config_file;