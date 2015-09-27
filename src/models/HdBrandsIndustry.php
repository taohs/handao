<?php

class HdBrandsIndustry extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $industry_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('brands_id', 'HdBrands', 'id', array('alias' => 'HdBrands'));
        $this->belongsTo('industry_id', 'HdIndustry', 'id', array('alias' => 'HdIndustry'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrandsIndustry[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrandsIndustry
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
        return 'hd_brands_industry';
    }

}
