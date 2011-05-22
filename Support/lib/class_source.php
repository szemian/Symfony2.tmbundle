<?php
/**
 * This file is part of Symfony2 textmate bundle
 * It uses Symfony2 universal loader to retrieve class source path
 * @author Koh Sze Mian <szemian@gmail.com>
 */
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}


if (PHP_VERSION_ID < 50302) {
    echo "Php version 5.3.2 and above required. Your php version is ".phpversion()."\nPrepend custom php path in Textmate Preferences > Advanced > Shell Variables > PATH";
}
else {

    require_once $_ENV['TM_PROJECT_DIRECTORY'].'/app/bootstrap.php.cache';
    require 'resolve_namespace.php';
    
    if(strpos($_ENV['TM_SCOPE'], 'entity.other.inherited-class.php') 
        || strpos($_ENV['TM_SCOPE'], 'support.class.php')) {
        
        $_ENV['TM_CURRENT_WORD'] = resolveClassName($_ENV['TM_CURRENT_WORD'], $_ENV['TM_FILEPATH']);
    }
    
    if($path = $loader->findFile($_ENV['TM_CURRENT_WORD'])) {
        echo realpath($path);
    } else {
        echo 'Class ' . $_ENV['TM_CURRENT_WORD'] . ' source file not found.';
    }
}