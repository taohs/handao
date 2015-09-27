<?php

class HdUserAutoReportLight extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     *
     * @var string
     */
    public $far_light;

    /**
     *
     * @var string
     */
    public $near_light;

    /**
     *
     * @var string
     */
    public $turn_light;

    /**
     *
     * @var string
     */
    public $brake_light;

    /**
     *
     * @var string
     */
    public $fog_light;

    /**
     *
     * @var string
     */
    public $small_light;

    /**
     *
     * @var string
     */
    public $reversing_light;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('report_id', 'HdUserAutoReport', 'id', array('alias' => 'HdUserAutoReport'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_user_auto_report_light';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportLight[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportLight
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
