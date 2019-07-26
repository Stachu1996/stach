<?php
   define('LOGINSTATE', true);
   define('REGISTERSTATE', false);
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 03.03.2019
 * Time: 17:14
 */

    class Controller implements IController{
        protected $request;
        protected $layout;
        protected $errors = [];


        //Load View
        public function view($view, $data = []){
            $view = new View($view, $data);
            $view->print();
        }

        public function error_msg($title = '', $desc = '', $data=[]){
            $errors_msg = [
                'title' => $title,
                'description' => $desc,
                'data' => $data
            ];
            $this->view('admin/inc/error', $errors_msg);
        }

        public function setRequest(Request $request){
            $this->request = $request;
        }
    }