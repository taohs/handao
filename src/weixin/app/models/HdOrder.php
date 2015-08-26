<?php

class HdOrder extends \Phalcon\Mvc\Model
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
    public $auto_id;

    /**
     *
     * @var string
     */
    public $products;

    /**
     *
     * @var double
     */
    public $price;

    /**
     *
     * @var double
     */
    public $total;

    /**
     *
     * @var double
     */
    public $fee;

    /**
     *
     * @var double
     */
    public $fax;

    /**
     *
     * @var integer
     */
    public $discount_type;

    /**
     *
     * @var double
     */
    public $discount_amount;

    /**
     *
     * @var string
     */
    public $discount_rate;

    /**
     *
     * @var double
     */
    public $true_pay;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrder[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrder
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
        return 'hd_order';
    }

}
