<?php

class HdUserAutoReportOilFilter extends \Phalcon\Mvc\Model
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
    public $spare_tire;

    /**
     *
     * @var string
     */
    public $engine_oil_callout;

    /**
     *
     * @var string
     */
    public $engine_oil_old_analyzing;

    /**
     *
     * @var string
     */
    public $air_filter;

    /**
     *
     * @var string
     */
    public $air_conditioning_filter;

    /**
     *
     * @var string
     */
    public $antifreeze_freezing;

    /**
     *
     * @var string
     */
    public $antifreeze_visual;

    /**
     *
     * @var string
     */
    public $antifreeze_level;

    /**
     *
     * @var string
     */
    public $steering_oil_visual;

    /**
     *
     * @var string
     */
    public $steering_oil_level;

    /**
     *
     * @var string
     */
    public $transmission_oil_visual;

    /**
     *
     * @var string
     */
    public $transmission_oil_level;

    /**
     *
     * @var string
     */
    public $glass_water;

    /**
     *
     * @var string
     */
    public $battery_appearance;

    /**
     *
     * @var string
     */
    public $battery_charge_level;

    /**
     *
     * @var string
     */
    public $battery_health_index;

    /**
     *
     * @var string
     */
    public $battery_pile;

    /**
     *
     * @var string
     */
    public $battery_led_color;

    /**
     *
     * @var string
     */
    public $hoses_lines;

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
     * @return HdUserAutoReportOilFilter[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdUserAutoReportOilFilter
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
        return 'hd_user_auto_report_oil_filter';
    }

}
