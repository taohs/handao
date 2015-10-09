<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    const SUCCESS_CODE = '000000';
    const PARAMS_ERROR_CODE = '100000';
    const LOGIC_ERROR_CODE = '200000';

    const ORIGIN_MOBILE = 'mobile';
    const ORIGIN_PORTAL = 'portal';
    const ORIGIN_BACKEND = 'backend';
    const ORIGIN_API = 'api';

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

    function responseJson($statusCode = '100000', $statusMsg = '用户不存在', $data = array())
    {
        $array = array('statusCode' => $statusCode, 'statusMsg' => $statusMsg, 'data' => $data);
        echo json_encode($array);
        exit;
    }
}
