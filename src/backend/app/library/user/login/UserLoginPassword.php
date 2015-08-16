<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 15:16
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 15:16
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class UserLoginPassword implements SplObserver
{
    public function update(SplSubject $subject){
        //todo some thing
        /**
         * @var $subject UserIdentity
         */
        if($subject->errorCode == 1){

        }
    }
}