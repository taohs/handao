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

<h2 class="sub-header">品牌列表</h2>
<div class="table-responsive">
    <a href="/brands/create" class="btn btn-primary">新增品牌</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>首字母</th>
            <th>名称</th>
            <th>国家</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for model in paginate.items %}
        {% set brands = model.getHdBrands() %}
        <tr>
            <td>{{brands.id}}</td>
            <td>{{brands.initials}}</td>
            <td>{{brands.name}} &nbsp;<img src="{{brands.logo_path}}" width="40px" height="20px"></td>
            <td>{{brands.country}}</td>
            <td>{{link_to("brands/update/" ~ brands.id,'编辑',true,'class':'abc')}} | {{link_to("brands/delete/" ~ brands.id,'删除品牌(暂时不做)',true,'class':'abc')}} </td>
        </tr>
        {% endfor %}
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

