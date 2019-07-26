<?php

class SessionMiddleware
{
    public function isLogin(){
        if(Session::isLoggedIn()){
            return true;
        }else{
            return Url::redirect('login');
            //throw new Exception("User is not logged");
        }
    }

    public function notLogin(){
        if(Session::isLoggedIn()) return Url::goBack();
        else return true;
    }

    public function isAdmin($level = 1){
        if(Session::isUserAdmin($level)) return true;
        else throw new Exception("insufficient permissions");
    }
}
