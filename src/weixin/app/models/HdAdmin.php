<?php

class HdAdmin extends \Phalcon\Mvc\Model
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
    public $nickname;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $role;

    /**
     *
     * @var string
     */
    public $limit;

    /**
     *
     * @var integer
     */
    public $is_valid;

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
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAdmin[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAdmin
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function initialize()
    {
        $this->belongsTo('role',"HdAdminRole",'id');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_admin';
    }

}
