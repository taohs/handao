<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 14:22
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 14:22
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */?>

<h2 class="sub-header">订单列表</h2>
<div class="table-responsive">
    <a href="create" class="btn btn-primary">新建订单</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>预约手机</th>
            <th>预约时间</th>
            <th>预约地点</th>
            <th>订单金额</th>
            <th>折扣金额</th>
            <th>实际金额</th>
            <th>支付状态</th>
            <th>订单状态</th>
            <th>技师</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% if paginate.items is not empty %}
        {% for model in paginate.items %}
        {% set linkman = model.getLinkman() %}
        {% set technician = model.getTechnician() %}
        {% set status = model.getStatus() %}

        <tr>
            <td>{{model.id}}</td>
            <td>{%if linkman %}{{ linkman.mobile }}{% endif %}</td>
            <td>{{model.book_time}}</td>
            <td>{{model.address_info}}</td>
            <td>{{model.total}}</td>
            <td>{{model.discount_amount}}</td>
            <td>{{model.price}}</td>
            <td>{% if model.payed_amount > 0  %} <strong style="color: green">已支付 ￥{{model.payed_amount}}</strong> {% else %}<strong style="color: red" > 未支付</strong> {% endif %}</td>
            <td>{% if status %} {{status}} {% endif %}</td>
            <td>{% if technician %}  {{technician.name}} {% endif %}</td>
            <td>
                {{link_to( dispatcher.getControllerName()~"/update/" ~ model.id,'编辑',true,'class':'abc')}} |
                {{link_to( dispatcher.getControllerName()~"/status/" ~ model.id,'状态',true,'class':'abc')}} |
                {{link_to( dispatcher.getControllerName()~"/pay/" ~ model.id,'支付',true,'class':'abc')}} |
                {{link_to(dispatcher.getControllerName()~"/assign/" ~ model.id,'指派技师')}} |
                {{link_to(dispatcher.getControllerName()~"/delete/" ~ model.id,'删除品牌(暂时不做)',true,'class':'abc')}}
            </td>
        </tr>
        {% set technician = null %}
        {% endfor %}
        {% endif %}
        </tbody>

    </table>
</div>
<div class="">
    <div class="form-inline">

        <a href="list">第一页</a>
        <a href="list?page=<?= $paginate->before; ?>">上一页</a>
        <a href="list?page=<?= $paginate->next; ?>">下一页</a>
        <a href="list?page=<?= $paginate->last; ?>">最后一页</a>
        <?php echo "您正在第 ", $paginate->current, "/", $paginate->total_pages,'页';  ?>
    </div>
</div>

