<?php

class WebsiteController extends Controller
{

    public function __construct(){

    }

    public function index(){
        $data = [
            'framework_author' => framework_author,
            'framework_version' => framework_version,
            'framework' => "STACH FRAMEWORK"
        ];
        $this->view('welcome', $data);
    }


}