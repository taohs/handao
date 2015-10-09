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
                    <col width="25%">
                    <col width="25%">
                    <col width="40%">
                    <col width="10%">
                </colgroup>
                <tbody>
                <tr>
                    <th>养护完成时间</th>
                    <th>订单号</th>
                    <th>养护项目</th>
                    <th>查看</th>
                </tr>
                {% for row in page.items %}
                <tr>
                    <td>{{row.service_time}}</td>
                    <td>{{row.id}}</td>

                    <td> {% set products = row.getProducts(row.products) %}
                        {% if products %}
                        {% for index,product in products %}
                        {{product}}{%if index+1 < products|length %}<hr>{%endif%}
                        {% endfor%}
                        {% endif %}
                    </td>
                    <td><a href="/report/detail/{{row.id}}"></a></td>

                </tr>
                {% endfor %}

                </tbody>
            </table>



                </tbody>
            </table>
            <div class="page">
                {{ link_to("user/finish?page=1", '&lt;&lt;首页') }} &nbsp;&nbsp;
                {{ link_to("user/finish?page=" ~ page.before , '上一页') }}&nbsp;&nbsp;
                {{ link_to("user/finish?page=" ~ page.next, '下一页') }}&nbsp;&nbsp;
                {{ link_to("user/finish?page=" ~ page.last , '末页&gt;&gt;') }}
            </div>
        </div>
    </div>


