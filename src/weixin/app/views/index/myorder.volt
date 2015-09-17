<div class="top">
    <p>
        <a href="/index/index" class="logo"><img src="{{url('images/logo.png')}}" width="98" height="44" alt=""/></a>
        欢迎您，{{userData.mobile}}
        <a href="/index/logout">退出</a>
    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="#" class="active">待养护</a>
            <a href="/index/myorderend">已养护</a>
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
                    <col width="13%">
                    <col width="7%">
                    <col width="15%">
                    <col width="15%">
                    <col width="25%">
                    <col width="10%">
                    <col width="15%">
                </colgroup>
                <tbody>
                <tr>
                    <th>订单号</th>
                    <th>预约时间</th>
                    <th>养护项目</th>
                    <th>订单金额</th>
                    <th>联系地址</th>
                    <th>联系人</th>
                    <th>联系电话</th>
                </tr>

                {% for row in page.items %}
                <tr>
                    <td>{{row.id}}</td>

                    <td>{{element.getTime(row.book_time)}}</td>
                    <td>
                        {% set products = row.getProducts(row.products) %}
                        {% if products %}
                        {% for index,product in products %}
                        {{product}}{%if index+1 < products|length %}<hr>{%endif%}
                        {% endfor%}
                        {% endif %}


                    <td>{{row.total}}</td>
                    <td>{{row.HdUserAddress.address}}</td>
                    <td>{{row.HdUserLinkman.name}}</td>
                    <td>{{row.HdUserLinkman.mobile}}</td>
                </tr>
                {% endfor %}

                </tbody>
            </table>
            <div class="page">
                {{ link_to("index/myorder?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
                {{ link_to("index/myorder?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
                {{ link_to("index/myorder?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
                {{ link_to("index/myorder?page=" ~ page.last , '末页&gt;&gt;') }}
            </div>
        </div>
    </div>


