<?php

function SMTP2GOClassLoader($className)
{
    $fileName  = '';
    $namespace = '';
    $includePath = dirname(__FILE__) . DIRECTORY_SEPARATOR ;
    
    if (false !== ($lastNsPos = strripos($className, '\\'))) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = 'app' . DIRECTORY_SEPARATOR;
    }

    if (strpos($namespace, 'SMTP2GO') === false) {
        return true;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFileName = $includePath . $fileName;

    if (file_exists($fullFileName)) {
        require_once $fullFileName;
    } else {
        exit('FAIL! Namespace: ' .$namespace .' Class "' . $className . '" wasn\'t found in ' . $includePath . ' as ' . $fileName);
    }
}
spl_autoload_register('SMTP2GOClassLoader');
