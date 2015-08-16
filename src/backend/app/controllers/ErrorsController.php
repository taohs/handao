<?php

/**
 * Class ErrorsController
 */

class ErrorsController extends  ControllerBase
{

    public function indexAction()
    {

    }

    /**
     *
     */
    public function show404Action(){
       var_dump($this->dispatcher->getParams());
    }

    public function show500Action(){
        var_dump($this->dispatcher->getParams());
        echo '500';
    }

}

