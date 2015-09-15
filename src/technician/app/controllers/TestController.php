<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/7/15
 * Time: 15:03
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/7/15  Time: 15:03
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class TestController extends ControllerBase
{
    function indexAction(){
        $this->view->disable();
//        $restful = new Restful();
//        $restful->init();
//        echo $restful->get('http://api.handao365.dev/sms/sendMessage/13883388101/nihao',array());
     echo    $this->restful->post('http://api.handao365.dev/user/logincode',array('mobile'=>'13883388101','code'=>'bugai'));
    }
}