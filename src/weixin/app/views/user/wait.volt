{{partial('user/_head')}}
<div class="content">
    {{partial('user/_tab')}}

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
                    <col width="7%">
                    <col width="23%">
                    <col width="20%">
                    <col width="10%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                </colgroup>
                <tbody>
                <tr>
                    <th>订单号</th>
                    <th>预约时间</th>
                    <th>保养项目</th>
                    <th>金额</th>
                    <th>地址</th>
<!--                    <th>联系人</th>-->
<!--                    <th>联系电话</th>-->
                </tr>

                {% for row in page.items %}
                <tr>
                    <td>{{row.id}}</td>

                    <td>{{row.book_time}}</td>
                    <td>
                        {% set products = row.getProducts(row.products) %}
                        {% if products is not empty %}
                        {% for index,product in products %}
                        {{product}}{%if index+1 < products|length %}<hr>{%endif%}
                        {% endfor%}
                        {% endif %}


                    <td>{{row.total}}</td>
                    <td>{{row.HdUserAddress.address}}</td>
<!--                    <td>{{row.HdUserLinkman.name}}</td>-->
<!--                    <td>{{row.HdUserLinkman.mobile}}</td>-->
                </tr>
                {% endfor %}

                </tbody>
            </table>
            <div class="page">
                {{ link_to("user/wait?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
                {{ link_to("user/wait?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
                {{ link_to("user/wait?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
                {{ link_to("user/wait?page=" ~ page.last , '末页&gt;&gt;') }}
            </div>
        </div>
    </div>


