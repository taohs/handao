<h2 class="sub-header">技师列表</h2>
{{flash.output()}}
<div class="table-responsive">
    <a href="/technician/updateuser" class="btn btn-primary">增加技师</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>手机号</th>
            <th>姓名</th>

            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in page.items %}
        <tr>
            <td>{{row.id}}</td>
            <td>{{row.username}}</td>
            <td>{{row.mobile}}</td>
            <td>{{row.name}}</td>
            <td>
                <a href="/technician/updateuser/{{row.id}}">编辑技师</a>
                <a href="/technician/resetpassword/{{row.id}}">重置密码</a>
                <a href="/technician/delete/{{row.id}}" class="delete">删除</a>
                <a href="/technician/active/{{row.id}}" class="active">{%if(row.active==0)%}激活{%else%}停用{%endif%}</a>
            </td>
        </tr>
        {% endfor %}

        </tbody>

    </table>
</div>
<div class="container">
    <div class="form-inline">
        {{ link_to("technician/list?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
        {{ link_to("technician/list?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
        {{ link_to("technician/list?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
        {{ link_to("technician/list?page=" ~ page.last , '末页&gt;&gt;') }}
    </div>
</div>

<script>
$('.delete').click(function(){
    if(confirm("确定要删除吗？")){

    }else{
        return false;
    }
});
$('.active').click(function(){
    var msg = $(this).html();
    if(confirm("确定要"+msg+"吗？")){

    }else{
        return false;
    }
})

</script>
