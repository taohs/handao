<?php

class HdUserAuto extends \Phalcon\Mvc\Model
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
    public $license;

    /**
     *
     * @var string
     */
    public $number;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $auto_cat_id;

    /**
     *
     * @var integer
     */
    public $models;

    /**
     *
     * @var string
     */
    public $year;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'HdUserAutoReport', 'auto_id', array('alias' => 'HdUserAutoReport'));
        $this->belongsTo('user_id', 'HdUser', 'id', array('alias' => 'HdUser'));
        $this->belongsTo('models', 'HdAutoModels', 'id', array('alias' => 'HdAutoModels'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAuto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAuto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function getModelExact(){
        return HdAutoModelsExact::findFirst($this->models);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_user_auto';
    }

}
