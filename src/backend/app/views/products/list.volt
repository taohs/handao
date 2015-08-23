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

<h2 class="sub-header">商品列表</h2>
<div class="table-responsive">
    <a href="create" class="btn btn-primary">新增商品</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>名称</th>
            <th>市场价</th>
            <th>会员价</th>
            <th>所属分类</th>
            <th>所属行业</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% if paginate.items is not empty %}
        {% for model in paginate.items %}
        <tr>
            <td>{{model.id}}</td>
            <td>{{model.market_price}}</td>
            <td>{{model.member_price}}</td>
            <td>{{model.name}}</td>
            <td>{{model.HdProductCategory.name}}</td>
            <td>{% if model.HDIndustry is not empty %}{{model.HDIndustry.name}}{% endif %}</td>
            <td>{{link_to( dispatcher.getControllerName()~"/update/" ~ model.id,'编辑',true,'class':'abc')}} | {{link_to(dispatcher.getControllerName()~"/delete/" ~ model.id,'删除品牌(暂时不做)',true,'class':'abc')}} </td>
        </tr>
        {% endfor %}
        {% endif %}
        </tbody>

    </table>
</div>
<div class="container">
    <div class="form-inline">

        <a href="list">第一页</a>
        <a href="list?page=<?= $paginate->before; ?>">上一页</a>
        <a href="list?page=<?= $paginate->next; ?>">下一页</a>
        <a href="list?page=<?= $paginate->last; ?>">最后一页</a>
        <?php echo "您正在第 ", $paginate->current, "/", $paginate->total_pages,'页';  ?>
    </div>
</div>

