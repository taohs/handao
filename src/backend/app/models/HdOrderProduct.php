<?php

class HdOrderProduct extends \Phalcon\Mvc\Model
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
    public $order_id;

    /**
     *
     * @var integer
     */
    public $product_id;

    /**
     *
     * @var integer
     */
    public $product_category;

    /**
     *
     * @var double
     */
    public $order_price;

    /**
     *
     * @var string
     */
    public $market_price;

    /**
     *
     * @var string
     */
    public $member_price;

    /**
     *
     * @var string
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
    public $logs;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('order_id', 'HdOrder', 'id', array('alias' => 'HdOrder'));
        $this->belongsTo('product_category', 'HdProductCategory', 'id', array('alias' => 'HdProductCategory'));
        $this->belongsTo('product_id', 'HdProduct', 'id', array('alias' => 'HdProduct'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_order_product';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrderProduct[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrderProduct
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
