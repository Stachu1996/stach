<?php

   //App Root
   define('APPROOT', dirname(dirname(dirname(__FILE__))).'/');
   //URL Root
   $url_prefix = "http://";
   $url = $url_prefix.$_SERVER['HTTP_HOST'].'/framework/';
   define('URLROOT', $url);

/**
 * FRAMEWORK INFO
 */
    define('framework_author', "Szymon Stach");
    define('framework_version', 0.1);

/**
 * DEFINE LOCALIZATION OF FILES
 */
    define('__APPDIR__', 'app/');

    define('__LIBDIR__', 'src/libraries/');
    define('__IDIR__', 'src/interfaces/');
    define('__HEDIR__', 'src/helpers/');
    define('__CONFIGDIR__', __APPDIR__.'config/');
    define('__LANGDIR__', __APPDIR__.'languages/');
    define('__CDIR__', __APPDIR__.'controllers/');
    define('__HDIR__', __APPDIR__.'helpers/');
    //define('__LDIR__', __APPDIR__.'layouts/');  // Layouts functionality disabled
    define('__MIDDIR__', __APPDIR__.'middlewares/');
    define('__MDIR__', __APPDIR__.'models/');
    define('__VDIR__', __APPDIR__.'views/');

    define("__AUTOLOADDIRECTORIES__", array( __LIBDIR__, __IDIR__, __HEDIR__, __CDIR__, __HDIR__, __MIDDIR__, __MDIR__));

    define('__ROUTESDIR__', __CONFIGDIR__.'routes');
    define('__FDIR__', 'src/functions/');

/**
 * DEFINE FUNTIONS TO BOOT
 */

    //LIST OF FUNCTIONS TO BOOT
    define('__FUNCTIONS__',
        array(
            'photosHelper',
            'sessionHelper',
            'translate'
        )
    );

    //LIST OF CONFIG FILES FROM app DIRECTORY TO READ
    define('__APPCONFIGS__', array(
        'config',
        'database',
        'mail'
    ));