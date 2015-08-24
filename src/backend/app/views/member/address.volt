<h2 class="sub-header">联系地址</h2>
<div class="table-responsive">
    <a href="/member/updateaddress?user_id={{user_id}}" class="btn btn-primary">新增</a>
    <a href="/member/list" class="btn btn-primary">返回</a>
    {{flash.output()}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>省</th>
            <th>城市</th>
            <th>地区</th>
            <th>地址</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for row in page.items %}
        <tr>
            <td>{{row.id}}</td>
            <td>{{row.province}}</td>
            <td>{{row.city}}</td>
            <td>{{row.area}}</td>
            <td>{{row.address}}</td>
            <td><a href="/member/updateaddress?user_id={{user_id}}&id={{row.id}}">编辑</a></td>
        </tr>
        {% endfor %}
        </tbody>

    </table>
</div>



