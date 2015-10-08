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


    function getUser($mobile)
    {
        $user = HdUser::findFirst(array('conditions' => 'mobile=:mobile:', 'bind' => array('mobile' => $mobile)));
        if (!$user) {
//            throw new \Phalcon\Exception("用户不存在");
//            return null;
        }
        return $user;
    }
    function getUserById($id)
    {
        $user = HdUser::findFirst($id);
        if (!$user) {
//            throw new \Phalcon\Exception("用户不存在");
//            return null;
        }
        return $user;
    }
    /**
     * 获取联系ID
     *
     * @param $user_id
     * @param $mobile
     * @param $name
     *
     * @return int
     */
    public function getLinkmanId($user_id, $mobile, $name)
    {
        $linkman = HdUserLinkman::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and mobile=:mobile: and name=:name:  ',
                'bind' => array('user_id' => $user_id, 'mobile' => $mobile, 'name' => $name)
            ));
        if ($linkman) {
            $linkmanId = $linkman->id;
        } else {
            $HdUserLinkman = new HdUserLinkman();
            $HdUserLinkman->mobile = $mobile;
            $HdUserLinkman->name = $name;
            $HdUserLinkman->user_id = $user_id;

            if ($HdUserLinkman->save()) {
                $linkmanId = $HdUserLinkman->id;

            }
        }
        return $linkmanId;
    }

    /**
     * 获取地址的ID
     *
     * @param $user_id
     * @param $address
     *
     * @return int
     */
    public function getAddressId($user_id, $address_info)
    {
        $address = HdUserAddress::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and address=:address:',
                'bind' => array('user_id' => $user_id, 'address' => $address_info)
            ));

        if ($address) {
            $addressId = $address->id;
        } else {
            $HdUserAddress = new HdUserAddress();
            $HdUserAddress->user_id = $user_id;
            $HdUserAddress->address = $address_info;
            if ($HdUserAddress->save()) {
                $addressId = $HdUserAddress->id;

            }
        }
        return $addressId;
    }

    /**
     * 获取车型的ID
     * @param $user_id
     * @param $models
     * @param $number
     *
     * @return int
     */
    public function getAutoModelsId($user_id, $models, $number)
    {
        $autoData = HdUserAuto::findFirst(
            array(
                'conditions' => 'models=:models: and user_id=:user_id: and number=:number:',
                'bind' => array('models' => $models, 'user_id' => $user_id, 'number' => $number)
            ));
        if ($autoData) {
            $auto_id = $autoData->id;
        } else {
            $HdUserAuto = new HdUserAuto;
            $HdUserAuto->user_id = $user_id;
            $HdUserAuto->models = $models;
            $HdUserAuto->number = $number;
            if ($HdUserAuto->save()) {
                $auto_id = $HdUserAuto->id;
            } else {
                throw new RuntimeException("用户汽车保存失败");
            }
        }
        return $auto_id;

    }
}