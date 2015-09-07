<style>
    body{background:url(/images/bg2.jpg)}

</style>
<div class="content" style="min-height: 494px;">
    <div style="background:#fff;margin-top:20px;" class="center">
        <div class="cfont">
            <h1>3</h1>
            <div style="background:url(images/xxtx.png) no-repeat left center" class="cfxz">选择服务</div>
        </div>
        <div class="zy_ny wp">
            <form action="/order/order" method="post" id="form-order" class="form-horizontal">

                <div class="hq">
                    <ul>
                        <li>
                            <span class="sp1">手机号：</span>
                            <input type="text" placeholder="11位手机号" auto-member="2" id="phone" name="mobile">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">姓名：</span>
                            <input type="text" placeholder="姓名" auto-member="1" id="truename" name="name">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">车牌号：</span>
                            <input type="text" placeholder="完整车牌号" name="carnum">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">服务时间：</span>
                            <input type="text" id="demo" name="bookTime[]">
                            <script>;!function(){laydate({elem: '#demo'})}();</script>
                            <select name="bookTime[]" id="time_select">
                                <option value="8:00-12:00 上午">9:00 - 12:00 上午</option>
                                <option value="12:00-14:00 中午">12:00 - 18:00 中午</option>
                                <option value="14:00-18:00 下午">18:00 - 22:00 下午</option>
                            </select>
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">服务地址：</span>
                            <input type="text" placeholder="完整地址" class="add" name="address">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">备注：</span>
                            <textarea name="remark"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="hw">
                    <table cellspacing="0" cellpadding="0" class="table">
                        <tbody>
                        <tr class="tr1">
                            <td width="300px">商品名称</td>
                            <td width="350px">服务项目</td>
                            <td>价格</td>
                            <td>总计</td>
                        </tr>
                        <tr>
                            <th class="th">{{autoName}} 上门保养</th>
                            <td>
                                <table>
                                    <tbody>
                                    {% for row in products %}
                                    <tr>
                                        <td>[  {{row['category']}}  ]&nbsp;  {{row['product']}}</td>
                                    </tr>
                                    {% endfor %}
                                    <tr><td>[其它]&nbsp;服务费</td></tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table1">
                                    <tbody>
                                    {% for row in orderDataId %}
                                    <tr>
                                        <td>{{row['price']}}</td>
                                    </tr>
                                    {% endfor %}
                                    <tr><td>{{fees}}</td></tr>
                                    </tbody>
                                </table>
                            </td>
                            <th class="th1">{{total}}<span>元</span></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="hr"><input type="submit" value="提交订单"></div>
            </form>
        </div>
    </div>
</div>
