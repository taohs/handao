<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/16/15
 * Time: 20:54
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/16/15  Time: 20:54
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class Letter
{
    protected $letterString = 'abcdefghijklmnopqrstuvwxyz';
    protected $letterArray = array(
        'a','b','c','d','e','f','g',
        'h','i','j','k','l','m','n',
        'o','p','q',    'r','s','t',
        'u','v','w',    'x','y','z'
    );

    public function getInitialsArray(){
        $initials = array();
        foreach ($this->letterArray as $v){
            $initials[] = strtoupper($v);
        }
        return $initials;
    }

}