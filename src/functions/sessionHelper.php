<?php
    session_start();

    function createUserSession($loggedInUser) {
        $_SESSION['user_session'] = true;
        $_SESSION['user_id'] = $loggedInUser->user_id;
        $_SESSION['user_email'] = $loggedInUser->user_email;
        $_SESSION['user_name'] =  $loggedInUser->user_name;
        $_SESSION['user_surname'] =  $loggedInUser->user_surname;
        $_SESSION['user_level'] =  $loggedInUser->user_level;
        if($loggedInUser->user_level>0) Url::redirect('admin');
        Url::redirect('panel');
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_session'])){
            return true;
        } else {
            return false;
        }
    }

    // Log out user
    function log_out() {
        // Destroy and unset active session
        unset($_SESSION['user_session']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_surname']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_level']);
        session_destroy();
        Url::redirect('');;
    }

    function getUserId(){
        return $_SESSION['user_id'];
    }

    function getUserLevel(){
        return $_SESSION['user_level'];
    }

    function isUserAdmin($level=1){
        if(getUserLevel()>=$level) return true;
        else return false;
    }

    if( isset( $_GET['logout'] ) ){
        log_out();
    }