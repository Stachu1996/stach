<?php

class Session
{
    static public function isLoggedIn(){
        if(isset($_SESSION['user_session'])){
            return true;
        } else {
            return false;
        }
    }

    static public function isUserAdmin($level=1){
        if(Session::getUserLevel()>=$level) return true;
        else return false;
    }

    public static function getUserId(){
        return $_SESSION['user_id'];
    }

    public static function getUserLevel(){
        return $_SESSION['user_level'];
    }

    
}
