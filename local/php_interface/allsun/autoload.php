<?php
/**
 * @about AllSun-Integration 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 */
function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNameSpacePosition = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNameSpacePosition);
        $className = substr($className, $lastNameSpacePosition + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/classes/' . $fileName) && !class_exists($className)) {
        require $_SERVER['DOCUMENT_ROOT'] . '/local/classes/' . $fileName;
    }
}

spl_autoload_register('autoload');

$other_vendor = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '/local/vendor/autoload.php';

if (file_exists($other_vendor)) {
    require_once $other_vendor;
}
