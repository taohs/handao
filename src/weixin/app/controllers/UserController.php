<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 15/10/8
 * Time: 23:31
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 15/10/8  Time: 23:31
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class UserController extends ControllerBase
{


    function initialize(){
        parent::initialize();
        if (!$this->session->get('auth')) {
            return $this->response->redirect("index/login?reUrl=user/".$this->dispatcher->getActionName());
        }

        $this->view->setVar('actionName',$this->dispatcher->getActionName());
    }


    function indexAction(){

        $auth = $this->session->get('auth');

        $linkman = HdUserLinkman::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            )
        ));
        $linkAddress = HdUserAddress::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            )
        ));
        $carInfo = HdUserAuto::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            )
        ));

        $this->view->setVar('linkman',$linkman);
        $this->view->setVar('linkAddress',$linkAddress);
        $this->view->setVar('carInfo',$carInfo);
    }

    function editAction(){
        $this->indexAction();
    }




    function waitAction(){

    }

    function finishAction(){

    }
}