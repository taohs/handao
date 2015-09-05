<?php

class HdUserAutoReportOther extends \Phalcon\Mvc\Model
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
    public $wipers_front;

    /**
     *
     * @var string
     */
    public $wipers_rear;

    /**
     *
     * @var string
     */
    public $fire_extinguisher;

    /**
     *
     * @var string
     */
    public $warning_sign;

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
     * @return HdUserAutoReportOther[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportOther
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
        return 'hd_user_auto_report_other';
    }

}
