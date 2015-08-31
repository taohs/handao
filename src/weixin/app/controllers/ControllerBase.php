<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public $fees=150.00;//服务费


    /**
     * 重新刷新
     */
    public function refresh(){
        return $this->response->redirect($this->request->getURI());
    }
}
