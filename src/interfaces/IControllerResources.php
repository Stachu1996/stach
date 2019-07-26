<?php

interface IControllerResources {
    /**
     *  main function in controller
     */
    public function index();
    /**
     *  show specific element
     */
    public function show(int $id);
    /**
     *  save newly created element
     */
    public function store();
    /**
     *  update element
     */
    public function update($id);
    /**
     *  delete specific element
     */
    public function destroy($id);
}