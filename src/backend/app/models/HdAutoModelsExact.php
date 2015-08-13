<?php

class HdAutoModelsExact extends \Phalcon\Mvc\Model
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
    public $year;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $brands_id;

    /**
     *
     * @var integer
     */
    public $models_id;

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
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_auto_models_exact';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoModelsExact[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdAutoModelsExact
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
