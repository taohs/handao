<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/7/15
 * Time: 00:35
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/7/15  Time: 00:35
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class UserComponent extends \Phalcon\Mvc\User\Component
{
    public function getUserByMobile($mobile)
    {
        $mobileValidator = new MobileValidator();

        if ($mobileValidator->validate($mobile)) {
            $user = HdUser::findFirst(array(
                'conditions' => 'mobile=:mobile:',
                'bind' => array('mobile' => $mobile)
            ));
        } else {
            $user = false;
        }
        return $user;
    }
}