<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/6/15
 * Time: 23:29
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/6/15  Time: 23:29
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class MobileValidator extends \Phalcon\Mvc\User\Component
{

    public $reg = '^1[3-9]{1}[0-0]{9}$';

    function validate($mobile){
        return preg_match('/^1[3-9]{1}[0-9]{9}$/',$mobile);
    }

}