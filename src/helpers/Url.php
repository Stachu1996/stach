<?php

class Url{
    
    static public function getUrl(){
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    }

    static public function current(){
        echo self::formatUri($_SERVER['REQUEST_URI']);
    }

    static public function link($url, $data = null){
        if(isset($data)){
            $query = '';
            if(is_array($data)) $query = http_build_query($data, '');
            else $query = urlencode($data);
            return URLROOT.$url.'?'.$query;
        }
        return URLROOT.$url;
    }
    static public function _link($url, $data = null){
        echo self::link($url, $data);
    }

    static public function redirect($url) {
        $link = "Location: ".URLROOT.$url;
        header($link);
    }

    static public function goBack(){
        if(isset($_SERVER['HTTP_REFERER'])) header($_SERVER['HTTP_REFERER']);
        else self::redirect('');
    }


    static public function back(){
        if(isset($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
        else return URLROOT;
    }

    static public function _back(){
        echo self::back();
    }

    static public function toPanel(){
        if(isLoggedIn()){
            if(isUserAdmin()){
                self::redirect("admin");
            }else{
                self::redirect("client");
            }
        }
    }

    private static function formatUri($uri, $with = false){
        if(isset($uri)){
            $url = rtrim($uri, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = strstr($url, '?', true)? strstr($url, '?', true) : $url;
            $url = explode('/', $url);

            while(isset($url[0]) && ($url[0]==='' || $url[0]==='GorajEsthetic' || $url[0]==="index.php")){
                array_shift($url);
            }

            $url = implode('/', $url);
            if($with) $url = '/'.$url;

            return $url;
        }
    }
}
