<?php

class HdUserAutoReportTire extends \Phalcon\Mvc\Model
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
    public $report_id;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     *
     * @var string
     */
    public $pressure;

    /**
     *
     * @var integer
     */
    public $factory_day_checkable;

    /**
     *
     * @var string
     */
    public $factory_day;

    /**
     *
     * @var string
     */
    public $tread_depth;

    /**
     *
     * @var string
     */
    public $aging;

    /**
     *
     * @var string
     */
    public $tread;

    /**
     *
     * @var string
     */
    public $sidewall;

    /**
     *
     * @var string
     */
    public $brake_pads_checkable;

    /**
     *
     * @var string
     */
    public $brake_pads_thickness;

    /**
     *
     * @var string
     */
    public $brake_dish;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('report_id', 'HdUserAutoReport', 'id', array('alias' => 'HdUserAutoReport'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportTire[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportTire
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
        return 'hd_user_auto_report_tire';
    }

}
