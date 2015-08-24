<?php

class TechnicianController extends ControllerBase
{
    public $pageLimit = 10;

    public function indexAction()
    {
        return $this->response->redirect( $this->dispatcher->getControllerName() . '/list' );
    }

    public function listAction()
    {
        echo 222;
    }

}

