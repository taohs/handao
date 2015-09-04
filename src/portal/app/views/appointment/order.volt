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
            <form action="/e/ShopSys/doaction.php" method="post" id="form-order" class="form-horizontal">
                <input type="hidden" value="AddSubScribe" name="enews">
                <input type="hidden" value="48" name="cxid">
                <input type="hidden" value="289" name="ksid">
                <input type="hidden" value="1.8T(B6)_2003.02-2004.04" name="ksname">
                <div class="hq">
                    <ul>
                        <li>
                            <span class="sp1">手机号：</span>
                            <input type="text" placeholder="11位手机号" auto-member="2" id="phone" name="phone">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">姓名：</span>
                            <input type="text" placeholder="姓名" auto-member="1" id="truename" name="truename">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">车牌号：</span>
                            <input type="text" placeholder="完整车牌号" name="carnum">
                            <span class="sp2">*</span>
                        </li>
                        <li>
                            <span class="sp1">服务时间：</span>
                            <input type="text" id="demo" name="fwdate">
                            <script>;!function(){laydate({elem: '#demo'})}();</script>
                            <select name="fwdate1" id="time_select">
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
                            <textarea name="bz"></textarea>
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
                            <th class="th">奥迪(一汽) A4 上门保养</th>
                            <td>
                                <table>
                                    <tbody>
                                    <tr><td>[机油]&nbsp;嘉实多金嘉护 SN 10W-40[￥174.0]</td></tr>
                                    <tr><td>[机油滤清器]&nbsp;马勒[￥25.0]</td></tr>
                                    <tr><td>[空气滤清器]&nbsp;马勒[￥69.0]</td></tr>
                                    <tr><td>[空调滤清器]&nbsp;马勒活性炭空调滤清器[￥89.0]</td></tr>
                                    <tr><td>[其它]&nbsp;服务费</td></tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table1">
                                    <tbody>
                                    <tr><td>174.00</td></tr>
                                    <input type="hidden" value="251" name="products[]">
                                    <tr><td>25.00</td></tr>
                                    <input type="hidden" value="811" name="products[]">
                                    <tr><td>69.00</td></tr>
                                    <input type="hidden" value="812" name="products[]">
                                    <tr><td>89.00</td></tr>
                                    <input type="hidden" value="813" name="products[]">
                                    <tr><td>150.00</td></tr>
                                    <input type="hidden" value="207" name="products[]">
                                    </tbody>
                                </table>
                            </td>
                            <th class="th1">507<span>元</span></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="hr"><input type="submit" value="提交订单"></div>
            </form>
        </div>
    </div>
</div>
