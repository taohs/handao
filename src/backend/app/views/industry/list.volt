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

<h2 class="sub-header">商品类型列表</h2>
<div class="table-responsive">
    <a href="create" class="btn btn-primary">新增商品类型</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>名称</th>
<!--            <th>父级</th>-->

            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% if paginate.items is not empty %}
        {% for model in paginate.items %}
        <tr>
            <td>{{model.id}}</td>
            <td>{{model.name}}</td>
<!--            <td>{{model.parent_id}}</td>-->

            <td>{{link_to( dispatcher.getControllerName()~"/update/" ~ model.id,'编辑',true,'class':'abc')}} | {{link_to(dispatcher.getControllerName()~"/delete/" ~ model.id,'删除品牌(暂时不做)',true,'class':'abc')}} </td>
        </tr>
        {% endfor %}
        {% endif %}
        </tbody>

    </table>
</div>

{{element.getPaginateLink(paginate)}}


