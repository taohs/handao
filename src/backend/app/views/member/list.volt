<h2 class="sub-header">会员列表</h2>
<div class="table-responsive">
    <a href="/member/updateuser" class="btn btn-primary">新增会员</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>会员姓名</th>
            <th>手机号</th>
            <th>保养车辆</th>
            <th>保养次数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in page.items %}
        <tr>
            <td>{{row.id}}</td>
            <td>

                {% set linkmans = row.getHdUserLinkman() %}
                {%for link in linkmans %}
                {%if loop.first%}
                {{link.name}}
                {%endif%}
                {%endfor%}


            </td>
            <td>{{row.mobile}}</td>
            <td>{{row.HdUserAuto.count()}}辆</td>
            <td>
                {% set b = 0 %}
                {% for a in row.HdUserAuto %}
                {% set b += a.HdUserAutoReport.count()%}
                {% endfor %}
                {{b}}次
            </td>
            <td><a href="/member/linkman/{{row.id}}">查看联系人</a>&nbsp;&nbsp;
                <a href="/member/address/{{row.id}}">查看地址</a>&nbsp;&nbsp;
                <a href="/member/auto/{{row.id}}">查看车辆</a>&nbsp;&nbsp;
                <a href="/member/updateuser/{{row.id}}">编辑用户</a>
            </td>
        </tr>
        {% endfor %}

        </tbody>

    </table>
</div>
<div class="container">
    <div class="form-inline">






        {{ link_to("member/list?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
        {{ link_to("member/list?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
        {{ link_to("member/list?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
        {{ link_to("member/list?page=" ~ page.last , '末页&gt;&gt;') }}


    </div>
</div>


