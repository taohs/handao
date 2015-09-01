<h2 class="sub-header">车辆</h2>
<div class="table-responsive">
    <a href="/member/updateauto?user_id={{user_id}}" class="btn btn-primary">新增</a>
    <a href="/member/list" class="btn btn-primary">返回</a>
    {{flash.output()}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>许可证</th>
            <th>车牌号</th>
            <th>汽车型号</th>
            <th>购买年份</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in page.items %}
        <tr>
            <td>{{row.id}}</td>
            <td>{{row.license}}</td>
            <td>{{row.number}}</td>
            <td>{{row.HdAutoModels.name}}</td>
            <td>{{row.year}}</td>
            <td><a href="/member/updateauto?user_id={{user_id}}&id={{row.id}}">编辑</a></td>
        </tr>
        {% endfor %}
        </tbody>

    </table>
</div>



