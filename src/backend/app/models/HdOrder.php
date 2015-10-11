<?php

class HdOrder extends \Phalcon\Mvc\Model
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
    public $user_id;

    /**
     *
     * @var integer
     */
    public $auto_id;

    /**
     *
     * @var string
     */
    public $products;

    /**
     *
     * @var double
     */
    public $price;

    /**
     *
     * @var double
     */
    public $total;

    /**
     *
     * @var double
     */
    public $fee;

    /**
     *
     * @var double
     */
    public $fax;

    /**
     *
     * @var integer
     */
    public $discount_type;

    /**
     *
     * @var double
     */
    public $discount_amount;

    /**
     *
     * @var string
     */
    public $discount_rate;

    /**
     *
     * @var double
     */
    public $true_pay;

    /**
     *
     * @var integer
     */
    public $linkman_id;

    /**
     *
     * @var string
     */
    public $linkman_info;

    /**
     *
     * @var string
     */
    public $address_id;

    /**
     *
     * @var string
     */
    public $address_info;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $logs;

    /**
     *
     * @var string
     */
    public $book_time;

    /**
     *
     * @var string
     */
    public $service_time;

    /**
     *
     * @var integer
     */
    public $technician_id;

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
     * @var double
     */
    public $payed_amount;

    /**
     *
     * @var string
     */
    public $payed_time;

    /**
     *
     * @var string
     */
    public $remark;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'HdOrderLog', 'order_id', array('alias' => 'HdOrderLog'));
        $this->hasMany('id', 'HdOrderProduct', 'order_id', array('alias' => 'HdOrderProduct'));
        $this->belongsTo('auto_id', 'HdUserAuto', 'id', array('alias' => 'HdUserAuto'));
        $this->belongsTo('user_id', 'HdUser', 'id', array('alias' => 'HdUser'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrder[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdOrder
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function getLinkman()
    {
        if (empty ($this->linkman_id))
            return false;
        return HdUserLinkman::findFirst($this->linkman_id);
    }


    public function getAuto()
    {
        if (empty ($this->auto_id))
            return false;
        return HdUserAuto::findFirst($this->auto_id);
    }


    public function getTechnician()
    {
        if (empty ($this->technician_id))
            return false;
        return HdTechnician::findFirst($this->technician_id);
    }
    public function getAddress()
    {
        if (empty ($this->address_id))
            return false;
        return HdUserAddress::findFirst($this->address_id);
    }


    public function beforeCreate()
    {
        $this->status = OrderComponent::STATUS_NEW_CREATE;
        $this->create_time = date('Y-m-d H:i:s');
    }


    public function beforeUpdate()
    {
        $this->update_time = date('Y-m-d H:i:s');
    }


    public function getPayedStatus()
    {
        if ($this->payed_amount > 0) {
            return $this->payed_amount;
        } else {
            return '未支付';
        }
    }


    public function getStatus()
    {
        $orderComponent = new OrderComponent();
        $statusArray = array_keys($orderComponent->statusArray);

        if (!in_array($this->status, $statusArray))
            $this->status = $orderComponent::STATUS_NEW_CREATE;
        return $orderComponent->statusArray[$this->status];

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_order';
    }

}
