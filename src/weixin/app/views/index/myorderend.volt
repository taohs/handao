<div class="top">
    <p>
<<<<<<< HEAD
        <a href="/index/index" class="logo"><img src="{{url('images/logo.png')}}" width="98" height="44" alt=""/></a>
        {{date('Y-m-d')}}&nbsp;&nbsp;欢迎您，{{userData.mobile}}
        <a href="/index/logout">退出</a>
=======
        <a href="#" class="logo"><img src="images/logo.png" width="98" height="44" alt=""/></a>
        {{date('Y-m-d')}}&nbsp;&nbsp;欢迎您，{{userData.mobile}}
        <a href="#">退出</a>
>>>>>>> a851b8c7358cf4f9b19b7fce89b042d27a86156c
    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="/index/myorder" >待养护</a>
            <a href="#" class="active">已养护</a>
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
                    <col width="30%">
                    <col width="30%">
                    <col width="40%">
                </colgroup>
                <tbody>
                <tr>
                    <th>养护完成时间</th>
                    <th>订单号</th>
                    <th>养护项目</th>
                </tr>
                {% for row in page.items %}
                <tr>
                    <td>{{row.service_time}}</td>
                    <td>{{row.id}}</td>

                    <td>{% for product in row.getProducts(row.products)%}
                        {{product}}<hr>
                        {% endfor %}
                    </td>

                </tr>
                {% endfor %}

                </tbody>
            </table>



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


