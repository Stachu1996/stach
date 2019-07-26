<?php

class Middleware
{
    public static function check($middleware){
        if($middleware===null) return true;

        if(is_array($middleware)){
            foreach($middleware as $key){
                if(!Middleware::procedure($key)) return false;
            }
            return true;
        }

        return Middleware::procedure($middleware) ? true : false;
    }

    private static function procedure($key){
        list($controller, $function, $args) = Middleware::decode($key);
        
        if(!class_exists($controller)) throw new BadMethodCallException('Bad middleware class call');
        $middleware = new $controller();
        if(!method_exists ($middleware, $function)) throw new BadMethodCallException('Bad middleware method call');
        if($args!==null) return $middleware->$function($args);
        return $middleware->$function();
    }

    private static function decode($key){
        $controller = ucfirst(strtolower(strstr($key, '@', true)))."Middleware";

        $function = strstr($key, '@');
        $function = ltrim($function, '@');
        $function = strstr($function, ':') ? strstr($function, ':', true) : $function;

        $args = null;
        if(strstr($key, ':')){
            $args = strstr($key, ':'); 
            $args = ltrim($args, ':');
        }

        return array($controller, $function, $args);
    }
}
