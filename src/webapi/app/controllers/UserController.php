<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/6/15
 * Time: 23:26
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/6/15  Time: 23:26
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class UserController extends ControllerBase
{

    function loginAction($mobile){
        $mobileValidator = new MobileValidator();

        if($mobileValidator->validate($mobile)){
            echo $this->security->getSaltBytes(3);
        }else{

        }
    }
}