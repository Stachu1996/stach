<?php

class View implements IView
{
    private $path;
    private $data = array();

    public function __construct($view, $data = null)
    {
        $this->setView($view);
        if($data!=null) $this->setData($data);
    }

    public function setView($view){
        $path = APPROOT.__VDIR__.$view.'.php';

        if(file_exists($path)){
            $this->path = $path;
        }else{
            return false;
        }
    }
    public function print(){
        if($this->path) require_once $this->path;
        else return false;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function __set($key, $value){
        $this->data[$key] = $value;
    }
    public function __get($key){
        return $this->data[$key];
    }

    public function e(String $key){
        if(isset($this->data[$key]) && !is_array($this->data[$key])) echo $this->data[$key];
    }
    public function v(String $key){
        if(isset($this->data[$key])) return $this->data[$key];
    }
}