<?php

abstract class Layout{

    protected $display = true;
    protected $styles = array();
    protected $scripts = array();
    protected $data = array();
    protected $currentPage = '';
    protected $views = array();
    protected $errors = null;

    //abstract function header();
    //abstract function content();
    //abstract function footer();

    public function print(){
        //ob_clean();
        $this->header();
        $this->content();
        $this->footer();
    }

    protected function printViews(){
        if(isset($this->views)){
            foreach($this->views as $view){
                $view->print();
            }
        }
    }

    protected function printErrors(){
        echo '<div class="container"><div class="row"><div class="col-12">';
        foreach ($this->errors as $error){
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
        echo '</div></div></div>';
    }

    function __destruct()
    {
        if($this->display) $this->print();
    }

    public function display(bool $display) :void
    {
        $this->display = $display;
    }

    public function addView(View $view){
        array_push($this->views, $view);
    }
    public function addStyle($style){
        if(is_array($style)){
            $this->styles = array_merge($this->styles, $style);
        }else {
            array_push($this->styles, $style);
        }
    }
    public function addScript($script){
        if(is_array($script)){
            $this->scripts = array_merge($this->scripts, $script);
        }else {
            array_push($this->scripts, $script);
        }
    }
    public function addData($d){
        array_push($this->data, $d);
    }
    public function addErrors($errors){
        if($this->errors === null) $this->errors = array();

        if(is_array($errors)){
            $this->errors = array_merge($this->errors, $errors);
        }else {
            array_push($this->errors, $errors);
        }
    }

    public function getCurrentPage(): string
    {
        return $this->currentPage;
    }
    public function setCurrentPage(string $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    public function __set($key, $value){
        $this->data[$key] = $value;
    }
    public function __get($key){
        return $this->data[$key];
    }


}