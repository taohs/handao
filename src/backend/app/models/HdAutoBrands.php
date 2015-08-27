<?php

class HdAutoBrands extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $brands_id;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('brands_id', 'HdBrands', 'id', array('alias' => 'HdBrands'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoBrands[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoBrands
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function beforeCreate(){
        $this->create_time = date('Y-m-d H:i:S');
    }


    public function beforeUpdate(){
        $this->update_time = date('Y-m-d H:i:S');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_auto_brands';
    }

}
