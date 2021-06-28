<?php

/**
 * @about GetCode 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 */
function autoload($_cn)
{
    $_cn = ltrim($_cn, '\\');
    $_fn = '';
    if ($lastNameSpacePosition = strrpos($_cn, '\\')) {
        $_ns = substr($_cn, 0, $lastNameSpacePosition);
        $_cn = substr($_cn, $lastNameSpacePosition + 1);
        $_fn = str_replace('\\', DIRECTORY_SEPARATOR, $_ns) . DIRECTORY_SEPARATOR;
    }
    $_fn .= str_replace('_', DIRECTORY_SEPARATOR, $_cn) . '.php';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/classes/' . $_fn) && !class_exists($_cn)) {
        require $_SERVER['DOCUMENT_ROOT'] . '/local/classes/' . $_fn;
    }
}

spl_autoload_register('autoload');

$other_vendor = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '/local/vendor/autoload.php';

if (file_exists($other_vendor))
    require_once $other_vendor;
#EOF