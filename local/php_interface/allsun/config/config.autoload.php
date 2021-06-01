<?php

$files = [
    'soap'
];

foreach($files as $k=>$f) {
    $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . $f . '.conf.php';
    if(file_exists($file))
        require_once $file;
}
