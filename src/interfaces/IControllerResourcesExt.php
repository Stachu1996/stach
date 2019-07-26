<?php

interface IControllerResourcesExt extends IControllerResources{

    /**
     *  show form for creating
     */
    public function create();
    /**
     *  show form for editing perpeses
     */
    public function edit($id);

}