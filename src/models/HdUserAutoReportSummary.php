<?php

class HdUserAutoReportSummary extends \Phalcon\Mvc\Model
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
    public $tire_brake;

    /**
     *
     * @var string
     */
    public $appearance_lighting;

    /**
     *
     * @var string
     */
    public $oil_filter_battery;

    /**
     *
     * @var string
     */
    public $other;

    /**
     *
     * @var string
     */
    public $total;

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
        return 'hd_user_auto_report_summary';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportSummary[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportSummary
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
