<h2 class="sub-header">角色</h2>
<div class="table-responsive">
    {{flash.output()}}
    <a href="/admin/roleupdate" class="btn btn-primary">新增</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>角色</th>
            <th>是否启用</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in page.items %}
        <tr>
            <td>{{row.id}}</td>
            <td>{{row.name}}</td>
            <td>{%if row.is_valid==1%}启用{%else%}禁用{%endif%}</td>
            <td><a href="/admin/roleupdate?id={{row.id}}">编辑</a></td>
        </tr>
        {% endfor %}
        </tbody>

    </table>
</div>



