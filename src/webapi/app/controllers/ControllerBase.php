<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected static $userComponent = null;

    function onConstruct(){
        $this->view->disable();
    }

    function getUserByMobile($mobile){
        if(is_null(self::$userComponent)){
            self::$userComponent = new UserComponent();
        }

        return self::$userComponent->getUserByMobile($mobile);
    }

    public function getCode($length = 4)
    {
        $code = null;

        for ($i = 0; $i < $length; $i++) {

            $code .= rand(0, 9);
        }

        return $code;
    }
}
