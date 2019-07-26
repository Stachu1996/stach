<?php
/**
 * Created by PhpStorm.
 * User: szymon
 * Date: 26.07.19
 * Time: 19:41
 */

interface IController
{
    public function view($view, $data = []);
    public function setRequest(Request $request);
}