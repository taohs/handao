

<h2 class="sub-header">会员列表</h2>
<div class="table-responsive">
    <a href="create" class="btn btn-primary">新增会员</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>手机号</th>
            <th>保养车辆（个数）</th>
            <th>保养次数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in data %}
        <tr>
            <td>{{row.id}}</td>
            <td>{{row.mobile}}</td>
            <td>{{row.HdUserAuto.count()}}</td>
            <td>
                {% set b = 0 %}
                {% for a in row.HdUserAuto %}
                {% set b += a.HdUserAutoReport.count()%}
                {% endfor %}
                {{b}}
            </td>
            <td><a href="linkman/{{row.id}}">编辑</a></td>
        </tr>
        {% endfor %}

        </tbody>

    </table>
</div>
<div class="container">
    <div class="form-inline">

        <a href="list">第一页</a>
        <a href="list?page=">上一页</a>
        <a href="list?page=">下一页</a>
        <a href="list?page=">最后一页</a>

    </div>
</div>


