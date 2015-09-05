<?php

class HdBrands extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $name_en;

    /**
     *
     * @var string
     */
    public $initials;

    /**
     *
     * @var string
     */
    public $logo_path;

    /**
     *
     * @var string
     */
    public $logo_small_path;

    /**
     *
     * @var string
     */
    public $logo_big_path;

    /**
     *
     * @var string
     */
    public $country;

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
        $this->hasMany('id', 'HdAutoModels', 'brands_id', array('alias' => 'HdAutoModels'));
        $this->hasMany('id', 'HdAutoModelsExact', 'brands_id', array('alias' => 'HdAutoModelsExact'));
        $this->hasMany('id', 'HdBrandsIndustry', 'brands_id', array('alias' => 'HdBrandsIndustry'));
        $this->hasMany('id', 'HdProductBrands', 'brands_id', array('alias' => 'HdProductBrands'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrands[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrands
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
        return 'hd_brands';
    }

}
