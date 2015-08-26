<?php

class HdProduct extends \Phalcon\Mvc\Model
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
    public $category;

    /**
     *
     * @var double
     */
    public $market_price;

    /**
     *
     * @var double
     */
    public $member_price;

    /**
     *
     * @var double
     */
    public $activity_price;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $attributes;

    /**
     *
     * @var integer
     */
    public $active;

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
        $this->hasMany('id', 'HdAutoProductRecommend', 'product_id', array('alias' => 'HdAutoProductRecommend'));
        $this->belongsTo('category', 'HdProductCategory', 'id', array('alias' => 'HdProductCategory'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdProduct[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdProduct
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
        return 'hd_product';
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


}
