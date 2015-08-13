<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    /**
     * @inheritdoc
     * 初始化方法
     */
    public function initialize(){
        $this->view->setLayout('main');
    }
}
