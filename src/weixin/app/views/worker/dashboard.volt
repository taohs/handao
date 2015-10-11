
<div class="top">
    <p>
        <a href="/worker/index" class="logo"><img src="{{url('/assets/images/logo.png')}}" width="98" height="44" alt=""/></a>
        {{date('Y-m-d')}}&nbsp;&nbsp;欢迎您，{{userData.name}}
        <a href="/worker/logout">退出</a>
    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a style="width: 50%;" href="/worker/dashboard" {%if status!=finished %}class="active"{%endif%}>待养护</a>
            <a style="width: 50%;" href="/worker/dashboard/finished"{%if status==finished %}class="active"{%endif%}>已养护</a>
        </p>
    </div>
    <div class="list show">
        <div class="sx">
            <!--<p class="time">
                <a href="index/myorder?day=1" class="today">今天</a>
                <a href="index/myorder?day=2" class="tom">明天</a>
            </p>-->
        </div>
        <div class="biao">
            <table>
                <colgroup>
                    <col width="8%">
                    <col width="12%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">


                </colgroup>
                <tbody>
                <tr>
                    <th>订单号</th>
                    <th>时间</th>
                    <th>养护项目</th>
                    <th>金额</th>
                    <th>联系地址</th>
                    <th>联系人</th>
                    <th>手机</th>
                    <th>报告</th>
                </tr>

                {% for row in page.items %}
                <tr>
                    <td>{{row.id}}</td>
                    <td>{{element.getTime(row.book_time)}}</td>
                    <td>{% for product in row.getProducts(row.products)%}

                        {{product}} <hr>
                        {% endfor%}


                    <td>{{row.total}}</td>
                    <td>{{row.HdUserAddress.address}}</td>
                    <td>{{row.HdUserLinkman.name}}</td>
                    <td>{{row.HdUserLinkman.mobile}}</td>

                    {% if row.status != orderSuccessStatus  %}
                        {% if status == 'finished' %}
                        <td> <a style="color: #fff;background: #1bbc9b;display: inline-block;padding: 5px 10px; line-height: 26px;margin: 10px 2px;border-radius:5px;" href="/report/detail/{{row.id}}">查看</a>
                            <a  style="color: #fff;background: #57b;display: inline-block;padding: 5px 10px; line-height: 26px;margin: 10px 2px;border-radius:5px;" href="/worker/updatereport/{{row.id}}">修改</a> </td>
                        {% else %}
                        <td> <a style="color: #fff;background: #57b;display: inline-block;padding: 5px 10px; line-height: 26px;margin: 10px 2px; border-radius:5px;" href="/worker/createreport/{{row.id}}" >填写报告</a> </td>
                        {% endif %}
                    {% else %}
                        <td> <a style="color: #fff;background: #57b;display: inline-block;padding: 5px 10px; line-height: 26px;margin: 10px 2px;border-radius:5px;" href="/report/detail/{{row.id}}">查看</a> </td>
                    {% endif %}
                </tr>
                {% endfor %}

                </tbody>
            </table>
            <div class="page">
                {{ link_to("/worker/dashboard/"~status~"?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
                {{ link_to("/worker/dashboard/"~status~"?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
                {{ link_to("/worker/dashboard/"~status~"?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
                {{ link_to("/worker/dashboard/"~status~"?page=" ~ page.last , '末页&gt;&gt;') }}
            </div>
        </div>
    </div>


