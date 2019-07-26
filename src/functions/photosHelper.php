<?php

$photos = [
    "main_img_ext" => array('./assets/img/website/main_img_ext.jpeg', ''),
    "main_img" => array('./assets/img/website/main_img.png', ''),
    "logo" => array('./assets/img/logo.svg', ''),
    "logo_white" => array('./assets/img/logo_white.svg', 'Logo white'),
];

function __img($photo, $class = '', $style = ''){
    global $photos;
    if(isset($photos[$photo])){
        $src = $photos[$photo][0];
        $alt = $photos[$photo][0];
        echo "<img src='$src' alt='$alt' class='$class' style='$style'>";
    }else{
        echo $photo;
    }
}

function __photo($key) {
    global $photos;
    if(isset($photos[$photo])){
        echo $photos[$photo][0];
    }else{
        echo $photo;
    }
}

function __photoalt($key) {
    global $photos;
    if(isset($photos[$photo])){
        echo $photos[$photo][1];
    }else{
        echo $photo;
    }
}
