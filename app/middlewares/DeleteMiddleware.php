<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 07.05.2019
 * Time: 15:57
 */

class DeleteMiddleware
{
    public function user($uid) : bool
    {
        if(Session::isUserAdmin(1)){
            if(Session::getUserId() == $uid){
                if(true){
                    return true;
                }else{
                    throw new Exception(__("USER_DONT_EXISTS"));
                }
            }else{
                throw new Exception(__("CANT_REMOVE_OWN_ACCOUNT"));
            }
        }else{
            throw new Exception(__("INSUFFICIENT_PERMISSIONS"));
        }
        return false;
    }
}