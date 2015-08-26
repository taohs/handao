<?php

class HdProductCategory extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var integer
     */
    public $industry_id;

    /**
     *
     * @var integer
     */
    public $property;

    /**
     *
     * @var string
     */
    public $description;

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
        $this->hasMany('id', 'HdProduct', 'category', array('alias' => 'HdProduct'));
        $this->belongsTo('industry_id', 'HdIndustry', 'id', array('alias' => 'HdIndustry'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdProductCategory[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdProductCategory
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function beforeCreate()
    {
        // Set the creation date
        $this->create_time = date('Y-m-d H:i:s');
    }


    public function beforeUpdate()
    {
        // Set the modification date
        $this->update_time = date('Y-m-d H:i:s');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_product_category';
    }

}
