<?php

class Voivodeship{

    static $voivodeship = array(
        0=>'dolnośląskie',
        1=>'kujawsko-pomorskie',
        2=>'lubelskie',
        3=>'lubuskie',
        4=>'łódzkie',
        5=>'małopolskie',
        6=>'mazowieckie',
        7=>'opolskie',
        8=>'podkarpackie',
        9=>'podlaskie',
        10=>'pomorskie',
        11=>'śląskie',
        12=>'świętokrzyskie',
        13=>'warmińsko-mazurskie',
        14=>'wielkopolskie',
        15=>'zachodniopomorskie'
    );

    public static function printVoivodeshipOptions($meta_address_voivodeship = null){
        foreach (self::$voivodeship as $item){
            if(isset($meta_address_voivodeship)){
                if( $item == $meta_address_voivodeship){
                    echo "<option selected>$item</option>";
                }else{
                    echo "<option>$item</option>";
                }
            }else{
                echo "<option>$item</option>";
            }
        }
    }




}
