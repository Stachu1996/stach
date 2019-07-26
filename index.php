<?php
/**
 *  S   T   A   C   H
 *  i   i   g   l   e
 *  m   n   i   e   l
 *  p   y   l   v   p
 *  l       e   e   f
 *  e           r   u
 *                  l
 */


/**
 *  BOOSTRAPPING APP
 */
    // require main config file
    require_once 'src/config/config.php';

    // set it to true while in development
    define("DEBUG_MODE", true);

    if(DEBUG_MODE) {
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

/**
 *      CHECK IF MOD_REWRITE IS AVAILABLE
 * if this module is not working framework will die
 */
    if(!function_exists('apache_get_modules') ){ 
        phpinfo(); exit; 
    }
    if(!in_array('mod_rewrite',apache_get_modules()))
        die('"mod_rewrite" Module Unavailable');

/**
 * AUTO LOAD CLASSES
 */
    spl_autoload_register(function($className){
        foreach( __AUTOLOADDIRECTORIES__ as $dir ) {
            if (file_exists($dir.$className.'.php')) {
                require_once($dir.$className.'.php');
                return;
            }
        }
    });

/**
 * AUTO LOAD USER CONFIG
 */
    foreach (__APPCONFIGS__ as $config) require_once ( __CONFIGDIR__ . $config . '.php');

/**
 * AUTO LOAD FUNCTIONS
 */
    foreach (__FUNCTIONS__ as $function) {
        if (file_exists(__FDIR__ . $function . '.php')) require_once( __FDIR__ . $function . '.php' );
    }

    require_once 'src/Init.php';
    $init = new Init();
