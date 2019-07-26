<?php

class Form
{   
    
    /** FORM */
    static public function open($action, $method='POST', $data=array() ){
        echo "<form action='$action' method='$method' ";
        
        if(isset($data['class'])) echo 'class="'.$data['class'].'" ';
        if(isset($data['id'])) echo 'id="'.$data['id'].'" ';
        if(isset($data['name'])) echo 'id="'.$data['name'].'" ';
        if(isset($data['attr'])) echo ' '.$data['attr'].'="'.$data['attr'].'"';

        echo ">";
    }
    static public function close(){
        echo '</form>';
    }
    /** EXTRA FORM ELEMENTS */   
    static public function method($method){
        echo "<input name='_method' type='hidden' value='$method'>";
    }
    /** buttons */
    static public function submit($text='Submit', $data = array('class'=>'btn btn-success')){
        echo "<button type='submit'";
        if(isset($data['class'])) echo 'class="'.$data['class'].'" ';
        if(isset($data['name'])) echo 'name="'.$data['name'].'" ';
        if(isset($data['id'])) echo 'id="'.$data['id'].'" ';
        echo ">$text</button>";
    }
    static public function button($text, $data=array('type'=>'button'), $selector='button'){
        echo "<$selector";
        self::handleData($data);
        echo ">$text</$selector>";
    }
    /** Inputs */
    static public function input($name, $value='', $data=array()){
        $data['name'] = $name;
        echo "<div class='form-group'>";
        if(isset($data['text'])){
            echo "<label";
            if(isset($data['id'])) echo " for='$data[id]'";
            if(isset($data['label-class'])) echo " class='".$data['label-class']."'";
            echo ">$data[text]</label>";
        }
        echo "<input value='$value'";
        self::handleData($data);
        echo "></div>";
    }
    static public function textarea($name, $value='', $data=array('class'=>'form-control')){
        $data['name'] = $name;
        echo "<div class='form-group'>";
        if(isset($data['text'])){
            echo "<label";
            if(isset($data['id'])) echo " for='$data[id]'";
            if(isset($data['label-class'])) echo " class='".$data['label-class']."'";
            echo ">$data[text]</label>";
        }
        echo "<textarea";
        self::handleData($data);
        echo ">$value</textarea></div>";
    }
    static public function select($name, $options, $selected=null, $data=array('class'=>'form-control')){
        $data['name'] = $name;
        echo "<div class='form-group'>";
        if(isset($data['text'])){
            echo "<label";
            if(isset($data['id'])) echo " for='$data[id]'";
            if(isset($data['label-class'])) echo " class='".$data['label-class']."'";
            echo ">$data[text]</label>";
        }
        echo "<select";
        self::handleData($data);
        echo ">";
        foreach ($options as $option) {
            if(is_array($option)){
                $s = ($option[0]==$selected || $option[1]==$selected) ? 'selected' : '';
                echo "<option $s value='$option[1]'>$option[0]</option>";
            }else{ 
                $s = $option==$selected ? 'selected' : '';
                echo "<option $s>$option</option>";
            }
        }
        echo "</select></div>";
    }


    static private function handleData($data){
        echo " ";
        if(isset($data)){
            foreach($data as $key => $value){
                echo "$key='$value' ";
            }
        }
/*
        if(isset($data['type'])) echo "type='".$data['type']."' ";
        if(isset($data['href'])) echo 'href="'.$data['href'].'" ';
        if(isset($data['class'])) echo 'class="'.$data['class'].'" ';
        if(isset($data['name'])) echo 'name="'.$data['name'].'" ';
        if(isset($data['id'])) echo 'id="'.$data['id'].'" ';
        if(isset($data['placeholder'])) echo 'placeholder="'.$data['placeholder'].'" ';
        if(isset($data['attr'])) echo ' '.$data['attr'].'="'.$data['attr'].'"'; */
    }
}