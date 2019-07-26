<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 19.05.2019
 * Time: 21:26
 */

class Assets
{
    public static function css($path){
        $path = URLROOT.'assets/css/'.$path;
        echo "<link rel='stylesheet' href='$path'>";
    }

    public static function script($path){
        $path = URLROOT.'assets/js/'.$path;
        echo "<script src='$path'></script>";
    }

    public static function img()
    {

    }

    public static function imgpath($img){
        return URLROOT.'assets/img/'.$img;
    }

    public static function path($item)
    {
        return APPROOT.$item;
    }
}