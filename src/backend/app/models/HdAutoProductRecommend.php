<?php

class HdAutoProductRecommend extends \Phalcon\Mvc\Model
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
    public $exact_id;

    /**
     *
     * @var integer
     */
    public $product_id;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_auto_product_recommend';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoProductRecommend[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoProductRecommend
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
