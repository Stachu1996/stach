<?php

interface IView{
    public function __construct($view, $data);

    public function setView($view);
    public function print();

    public function setData($data);

    public function __set($key, $value);
    public function __get($key);

    public function e(String $key);
    public function v(String $key);
}