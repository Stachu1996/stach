<?php
    class Validation {
        /**
         * Method 	    Parameter 	    Description 	                                                            Example
         * name 	    $name 	        Return field name 	                                                        name('name')
         * value 	    $value 	        Return value field 	                                                        value($_POST['name])
         * file 	    $value 	        Return $_FILES array 	                                                    file($_FILES['name'])
         * 
         * pattern 	    $pattern        Return an error if the input has a different format than the pattern 	    pattern('text')
         * customPattern $pattern       Return an error if the input has a different format than the custom pattern customPattern('[A-Za-z]')
         * 
         * required 		            Returns an error if the input is empty 	                                    required()
         * min 	        $length         Return an error if the input is shorter than the parameter 	                min(10)
         * max 	        $length         Return an error if the input is longer than the parameter 	                max(10)
         * equal 	    $value 	        Return an error if the input is not same as the parameter 	                equal($value)
         * maxSize 	    $value 	        Return an error if the file size exceeds the maximum allowable size 	    maxSize(3145728)
         * ext 	        $value 	        Return an error if the file extension is not same the parameter 	        ext('pdf')
         * 
         * isSuccess 		            Return true if there are no errors 	                                        isSuccess()
         * getErrors 		            Return an array with validation errors 	                                    getErrors()
         * displayErrors 	            Return Html errors 	                                                        displayErrors()
         * result 		                Return true if there are no errors or html errors 	                        result()
         * 
         * is_int 	    $value 	        Return true if the value is an integer number 	                            is_int(1)
         * is_float     $value 	        Return true if the value is an float number 	                            is_float(1.1)
         * is_alpha     $value 	        Return true if the value is an alphabetic characters 	                    is_alpha('test')
         * is_alphanum  $value          Return true if the value is an alphanumeric characters 	                    is_alphanum('test1')
         * is_url   	$value 	        Return true if the value is an url (protocol is required) 	                is_url('http://www.example.com')
         * is_uri 	    $value 	        Return true if the value is an uri (protocol is not required) 	            is_uri('www.example.com')
         * is_bool 	    $value 	        Return true if the value is an boolean 	                                    is_bool(true)
         * is_email     $value 	        Return true if the value is an e-mail 	                                    is_email('email@email.com')
         * 
         * Name 	    Description 	                                                Example
         * uri 	        Url without file extension 	                                    folder-1/folder-2
         * url 	        Uri with file extension 	                                    http://www.example.com/myfile.gif
         * alpha 	    Only alphabetic characters 	                                    World
         * words 	    Alphabetic characters and spaces 	                            Hello World
         * alphanum 	Alpha-numeric characters 	                                    test2016
         * int 	        Integer number 	                                                154
         * float 	    Float number 	                                                1,234.56
         * tel 	        Telephone number 	                                            (+39) 081-777-77-77
         * text 	    Alpha-numeric characters, spaces and some special characters 	Test1 ,.():;!@&%?
         * file 	    File name format 	                                            myfile.png
         * folder 	    Folder name format 	                                            my_folde
         * address 	    Address format 	                                                Street Name, 99
         * date_dmy 	Date in format dd-MM-YYYY 	                                    01-01-2016
         * date_ymd 	Date in format YYYY-MM-dd 	                                    2016-01-01
         * email 	    E-Mail format 	                                                exampe@email.com
         *  
         *    $email = 'example@email.com';
         *    $username = 'admin';
         *    $password = 'test';
         *    $age = 29;
         *    
         *    $val = new Validation();
         *    $val->name('email')->value($email)->pattern('email')->required();
         *    $val->name('username')->value($username)->pattern('alpha')->required();
         *    $val->name('password')->value($password)->customPattern('[A-Za-z0-9-.;_!#@]{5,15}')->required();
         *    $val->name('age')->value($age)->min(18)->max(40);
         *    
         *    if($val->isSuccess()){
         *    	echo "Validation ok!";
         *    }else{
         *      echo "Validation error!";
         *      var_dump($val->getErrors());
         *    }
         * */

        
        // https://github.com/davidecesarano/Validation

        public $patterns = array(
            'uri'           => '[A-Za-z0-9-\/_?&=]+',
            'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
            'alpha'         => '[\p{L}]+',
            'words'         => '[\p{L}\s]+',
            'alphanum'      => '[\p{L}0-9]+',
            'int'           => '[0-9]+',
            'float'         => '[0-9\.,]+',
            'tel'           => '[0-9+\s()-]+',
            'text'          => '[\S\s]+',
            'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
            'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
            'address'       => '[\p{L}0-9\s.,()°-]+',
            'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
            'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
            'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+',
            'zipcode'       => '[0-9]{2}-[0-9]{3}',
            'password'      => '(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*',
        );
        public $errors = array();
        
        public function name($name){
            $this->name = $name;
            return $this;
        }
        public function value($value){
            $this->value = $value;
            return $this;
        }
        public function file($value){
            $this->file = $value;
            return $this;
        }
        public function required(){
            if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null) && $this->value !== 0){
                $this->errors[] = 'Pole '.$this->name.' wymagane.';
            }            
            return $this;
        }
        
        public function pattern($name){
            if($name == 'array'){
                if(!is_array($this->value)){
                    $this->errors[] = 'Format pola '.$this->name.' niewłaściwy.';
                }
            }else{
                $regex = '/^('.$this->patterns[$name].')$/u';
                if($this->value != '' && !preg_match($regex, $this->value)){
                    $this->errors[] = 'Format pola '.$this->name.' niewłaściwy.';
                }
            }
            return $this;
        }
        
        public function customPattern($pattern){
            $regex = '/^('.$pattern.')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'Format pola '.$this->name.' niewłaściwy.';
            }
            return $this;
        }

        public function min($length){
            if(is_string($this->value)){
                if(strlen($this->value) < $length){
                    $this->errors[] = 'Wartość pola '.$this->name.' niższa od wartości minimalnej.';
                }
            }else{
                if($this->value < $length){
                    $this->errors[] = 'Wartość pola '.$this->name.' niższa od wartości minimalnej.';
                }
            }
            return $this;
        }
        public function max($length){
            if(is_string($this->value)){
                if(strlen($this->value) > $length){
                    $this->errors[] = 'Wartość pola '.$this->name.' wyższa od wartości maksymalnej.';
                }
            }else{
                if($this->value > $length){
                    $this->errors[] = 'Wartość pola '.$this->name.' wyższa od wartości maksymalnej.';
                }
            }
            return $this;
        }
        
        public function equal($value){
            if($this->value != $value){
                $this->errors[] = 'Wartość pola '.$this->name.' niewłaściwa.';
            }
            return $this;
        }
        
        public function maxSize($size){
            
            if($this->file['error'] != 4 && $this->file['size'] > $size){
                $this->errors[] = 'Plik '.$this->name.' przekracza dopusznalny rozmiar '.number_format($size / 1048576, 2).' MB.';
            }
            return $this;
            
        }

        public function ext($extension){
            if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
                $this->errors[] = 'Plik '.$this->name.' nie jest '.$extension.'.';
            }
            return $this;
            
        }

        public function purify($string){
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }

        public function isSuccess(){
            if(empty($this->errors)) return true;
        }
        public function getErrors(){
            if(!$this->isSuccess()) return $this->errors;
        }
        
        public function displayErrors(){            // USLESS
            $html = '<ul>';
                foreach($this->getErrors() as $error){
                    $html .= '<li>'.$error.'</li>';
                }
            $html .= '</ul>';
            return $html;
        }
        
        public function result(){    
            if(!$this->isSuccess()){
                foreach($this->getErrors() as $error){
                    echo "$error\n";
                }
                exit;
            }else{
                return true;
            }
        }
        
        /** 
         *   CHECK FUNCTIONS 
         */
        public static function is_int($value){
            if(filter_var($value, FILTER_VALIDATE_INT)) return true;
        }
        public static function is_float($value){
            if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
        }
        public static function is_alpha($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
        }
        public static function is_alphanum($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
        }
        public static function is_url($value){
            if(filter_var($value, FILTER_VALIDATE_URL)) return true;
        }
        public static function is_uri($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
        }
        public static function is_bool($value){
            if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
        }
        public static function is_email($value){
            if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
        }

        
        /**
         *  SANITIZE FUNCTIONS
         */
        public static function int($value){
            return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        }
        public static function float($value){
            return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
        }
        public static function url($value){
            return filter_var($value, FILTER_SANITIZE_URL);
        }
        public static function email($value){
            return filter_var($value, FILTER_SANITIZE_EMAIL);
        }
        public static function text($value){
            return filter_var($value, FILTER_SANITIZE_STRING);
        }
    }
