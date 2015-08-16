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

<h2 class="sub-header">管理人员列表</h2>
<div class="table-responsive">
    <a href="/admin/create" class="btn btn-primary">新增管理员</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>用户名</th>
            <th>角色</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for admin in paginate.items %}
        <tr>
            <td>{{admin.id}}</td>
            <td>{{admin.username}}</td>
            <td>{{admin.getHdAdminRole().name}}</td>
            <td>{{admin.is_valid ? "启用" : "关闭"}}</td>
            <td>{{link_to("admin/update/" ~ admin.id,'编辑',true,'class':'abc')}} | {{link_to("admin/reset/" ~ admin.id,'重置密码',true,'class':'abc')}} </td>
        </tr>
        {% endfor %}
        </tbody>


    </table>
</div>
<div class="container">
    <div class="form-inline">
    <a href="/admin/list">第一页</a>
    <a href="/admin/list?page=<?= $paginate->before; ?>">上一页</a>
    <a href="/admin/list?page=<?= $paginate->next; ?>">下一页</a>
    <a href="/admin/list?page=<?= $paginate->last; ?>">最后一页</a>
    <?php echo "您正在第 ", $paginate->current, "/", $paginate->total_pages,'页';  ?>
    </div>
</div>

