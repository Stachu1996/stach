<?php

class Route
{
    private $request;

    private $get = array();
    private $post = array();
    private $delete = array();
    private $put = array();
    private $patch = array();

    private $supportedHttpMethods = array(
        "GET",
        "POST",
        "DELETE",
        "PUT",
        "PATCH",
    );

    function __construct(IRequest $request){
        $this->request = $request;
    }

    function crud($path, $controller, $middleware){
        $this->get($path, $controller.'@index', $middleware );
        $this->get($path.'/:id', $controller.'@show', $middleware );
        $this->post($path, $controller.'@store', $middleware );
        $this->patch($path.'/:id', $controller.'@update', $middleware );
        $this->delete($path.'/:id', $controller.'@destroy', $middleware );
    }

    function __call($name, $args){
        list($route, $controller) = $args;
        $method = 'index';

        if(strstr($controller, '@')){ 
            $method = ltrim(strstr($controller, "@"), '@');
            $controller = strstr($controller, '@', true);
        }

        if(!in_array(strtoupper($name), $this->supportedHttpMethods)) $this->invalidMethodHandler(); // check i valid method used
        $route = $this->explodeRoute($route);

        $link =& $this->{strtolower($name)};
        for ($i=0; $i < count($route); $i++) { 
            if(count($route) == 1+$i ){
                $set = array(
                    'controller' => $controller,
                    'method' => $method,
                    'middleware' => isset($args[2])? $args[2] : null,
                );
                $link[$route[$i]] = $set;
            }else{
                if(!isset($link[$route[$i]])) $link[$route[$i]]= array();
                $link =& $link[$route[$i]];
            }
        }
//        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }
    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route){
        $result = rtrim($route, '/');
        return $result === '' ? '/' : $result;
    }
    private function explodeRoute($route){
        $route = rtrim($route, '/');
        $route = explode('/', $route);
        while(isset($route[0]) && ($route[0]==='' || $route[0]===' ' || $route[0]==="index.php")){
            array_shift($route);
        }
        if(!isset($route[0])) $route[0] = '/';
        return $route;
    }

    private function invalidMethodHandler(){
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }
    private function defaultRequestHandler(){
        header("{$this->request->serverProtocol} 404 Not Found");
    }
    /**
     * Resolves a route
     */
    function resolve(){
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->request->getUrl(true);
        
        $this->set = $this->matchRoute($methodDictionary, $formatedRoute);
    }

    private function matchRoute(array $dictionary, $url){
        $link =& $dictionary;
        for($i=0; $i<count($url); $i++){
            if(isset($link[$url[$i]])){
                if(count($url) == 1+$i ){
                    $controller = isset( $link[$url[$i]]['controller'] )? $link[$url[$i]]['controller'] : null;
                    $method = isset( $link[$url[$i]]['method'] )? $link[$url[$i]]['method'] : null;
                    $middleware = isset( $link[$url[$i]]['middleware'] )? $link[$url[$i]]['middleware'] : null;
                    $set = array( 'controller' => $controller, 'method' => $method, 'middleware' => $middleware);
                    return $set;
                }
                $link =& $link[$url[$i]];
            }else{
                if(count($url) == 1+$i ){
                    $keys = array_keys($link);
                    foreach($keys as $key){
                        $att = strstr($key, ':');
                        $att = ltrim($att, ':');
                        if(strstr($key, ':')){
                            $controller = isset( $link[$key]['controller'] )? $link[$key]['controller'] : null;
                            $method = isset( $link[$key]['method'] )? $link[$key]['method'] : null;
                            $middleware = isset( $link[$key]['middleware'] )? $link[$key]['middleware'] : null;
                            if($att =='id') $attr = (int) $url[$i];
                            else if($att == 'name') $attr = (string) $url[$i];
                            else $attr = null;
                            $set = array('controller' => $controller, 'middleware' => $middleware, 'method' => $method, 'attribute' => $attr);
                            return $set;
                        }
                    }
                }
            }

        }
        return false;
    }

    function __destruct(){
        //$this->resolve();
        //echo '<pre>';
        //print_r($this);
        //echo '</pre>';
//
    }



}
