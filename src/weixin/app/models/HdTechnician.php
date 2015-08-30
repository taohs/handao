<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class HdTechnician extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $mobile;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     *
     * @var integer
     */
    public $role;
    /**
     *
     * @var string
     */
    public $name;
    /**
     * Initialize method for model.
     */
    public function initialize()
    {

    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
//        $this->validate(
//            new Email(
//                array(
//                    'field'    => 'email',
//                    'required' => true,
//                )
//            )
//        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUser[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUser
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_technician';
    }

    public function beforeCreate(){
        $this->create_time = date('Y-m-d H:i:s');
    }

    public function beforeUpdate(){
        $this->update_time = date('Y-m-d H:i:s');
    }

}
