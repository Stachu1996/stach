<?php

class Request implements IRequest
{
    private $supportedHttpMethods = array(
        "GET",
        "POST",
        "DELETE",
        "PUT",
        "PATCH",
    );

    function __construct(){
        $this->bootstrap();
        $this->thisURL = $this->getUrl();
    }
    private function bootstrap(){
        //echo "<pre>";
        foreach($_SERVER as $key => $value){
            $this->{$this->toCamelCase($key)} = $value;
            //echo "<br>[$key] $value";
        }
        //echo "<pre>";

        if($this->requestMethod=="POST"){
            if(isset($_POST["_method"]) && in_array(strtoupper($_POST['_method']), $this->supportedHttpMethods)){
                $this->requestMethod=strtoupper($_POST['_method']);
            }
        }
    }
    private function toCamelCase($string){
        $result = strtolower($string);
        preg_match_all('/_[a-z]/', $result, $matches);
        foreach($matches[0] as $match){
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }
    public function getUrl(bool $explode = false){
        if(isset($this->requestUri)){
            $url = rtrim($this->requestUri, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = strstr($url, '?', true)? strstr($url, '?', true) : $url;
            $url = explode('/', $url);

            while(isset($url[0]) && ($url[0]==='' || $url[0]===URLPREFIX || $url[0]==="index.php")){
                array_shift($url);
            }

            if($explode) {
                if(!isset($url[0])) $url[0] = '/';
                return $url;
            }
            $url = implode('/', $url);
            $url = '/'.$url;

            return $url;
        }
    }
    public function getBody(){
        if($this->requestMethod === "GET"){
            $body = array();
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $body;
        }
        if ($this->requestMethod == "POST" || $this->requestMethod == "DELETE" || $this->requestMethod == "PUT" || $this->requestMethod == "PATCH"){
            $body = array();
            foreach($_POST as $key => $value){
                if(is_array($value)) $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                else{
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            return $body;
        }
    }

    public function getJson(){
        if($this->requestMethod ==="PATCH" || $this->getRequestMethod() ==="DELETE"){
            parse_str(file_get_contents('php://input'), $_PATCH);
            return $_PATCH;

            $body = array();
            foreach($_PATCH as $key => $value){
                $body[$key] = $value;
            }
            return $body;
        }
    }
    public function setRequestMethod(string $method) :void
    {
        $_SERVER["REQUEST_METHOD"] = $method;
        $this->requestMethod = $method;
    }

    public function getRequestMethod() :string
    {
        return $this->requestMethod;
    }
}
