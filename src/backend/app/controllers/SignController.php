<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/13/15
 * Time: 22:30
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/13/15  Time: 22:30
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

/**
 * Class SignController
 */
class SignController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        echo time();
        var_dump(time());
    }

    /**
     * deal form post
     *
     */
    public function inAction(){

        $this->dispatcher->forward(array('action'=>'index'));
    }

    /**
     *
     */
    public function outAction(){

    }

}

