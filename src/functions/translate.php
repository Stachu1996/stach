
<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 2/17/2019
 * Time: 12:46 PM
 */

$supportedLanguages = __LANGUAGES__;
$lang = __DEFAULT_LANGUAGE__;

if( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ){
    $lang = in_array( substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2), $supportedLanguages) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) : $lang;
}else{
    $lang = isset($_GET['lang']) ? $_GET['lang'] : $lang;
}

if(file_exists('assets/languages/lang_'.$lang.'.php')) {
    include_once(__LANGDIR__.'lang_'.$lang.'.php');
} else {
    include_once(__LANGDIR__.'lang_pl.php');
}

function _e($key) {
    global $language;
    if(isset($language[$key])) {
        echo $language[$key];
    } else {
        echo $key;
    }
}

function __($key) {
    global $language;
    if(isset($language[$key])) {
        return $language[$key];
    } else {
        return $key;
    }
}
