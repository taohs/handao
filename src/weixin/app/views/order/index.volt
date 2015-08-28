
<form class="form-horizontal" id="form-order" method="post" action="order/order">
    <div class="Xd">
        <h2 class="t">
            <em><a href="/">&lt;首页</a></em>订单详情
        </h2>
        <ul class="m">
            <li>
                <p class="p1"><span class="sp1">*</span>姓名：</p>
                <input name="name" type="text">
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>手机号：</p>
                <input name="mobile" type="text">
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务地址：</p>
                <input name="address" type="text">
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>完整车牌号：</p>
                <input name="carnum" type="text">
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务日期：</p>
                <input name="serviceTime[]" type="date">
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务时间段：</p>
                <select name="serviceTime[]">
                    <option value="8:00-12:00 上午">8:00 - 12:00 上午</option>
                    <option value="12:00-14:00 中午">12:00 - 14:00 中午</option>
                    <option value="14:00-18:00 下午">14:00 - 18:00 下午</option>
                    <option value="18:00-24:00 晚上">18:00 - 24:00 晚上</option>
                    <option value="00:00-08:00 凌晨">00:00 - 08:00 凌晨</option>
                </select>
            </li>
        </ul>
        <div class="text">
            <div class="p"> <span>备注：</span>
                <textarea name="remark"></textarea>
            </div>
        </div>
        <div class="k">
            <p class="re">商品名称：  {{autoName}}  上门保养 </p>
            <table class="table" cellspacing="0">
                <tbody>
                <tr class="t">
                    <th width="65%">保养项目</th>
                    <th width="18%">价格</th>
                    <th width="17%">总价</th>
                </tr>
                <tr class="th">
                    <th>
                        <table>
                            <tbody>
                            {% for row in products %}
                            <tr>
                                <td>[  {{row['category']}}  ]&nbsp;  {{row['product']}}</td>
                            </tr>
                            {% endfor %}
                            <tr><td>服务费</td></tr>
                            </tbody>
                        </table>
                    </th>
                    <th>
                        <table>
                            <tbody>

                            {% for row in orderDataId %}
                            <tr>
                                <td>{{row['price']}}</td>
                            </tr>
                            {% endfor %}
                            <tr><td>{{fees}}</td></tr>
                            </tbody>
                        </table>
                    </th>
                    <th class="pic">￥  {{total}}</th>
                </tr>
                </tbody>
            </table>
        </div>
        <br><br>
        <div class="tj">
            <p class="z"> <b>当前费用：</b><span>￥  {{total}}  元</span><br>  支持现金、刷卡支付 </p>
            <p class="y">
                <input value="提交订单" type="submit">
            </p>
        </div>
    </div>
</form>
