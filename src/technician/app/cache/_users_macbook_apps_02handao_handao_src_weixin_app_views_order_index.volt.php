
<form class="form-horizontal" id="form-order" method="post" action="order/order" onsubmit="return memberAddressForm.validate();">
    <div class="Xd">
        <h2 class="t">
            <em><a href="/">&lt;首页</a></em>订单详情
        </h2>
        <?php echo $this->flash->output(); ?>
        <ul class="m">
            <li>
                <p class="p1"><span class="sp1">*</span>姓名：</p>
                <input name="name" id="name" type="text">
                <em id="name_em" style="color: red; display: none;">姓名不能为空</em>
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>手机号：</p>
                <input name="mobile" id="mobile" type="text">
                <em id="mobile_em" style="color: red; display: none;">手机号不能为空</em>
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务地址：</p>
                <input name="address" id="address" type="text">
                <em id="address_em" style="color: red; display: none;">服务地址不能为空</em>
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>完整车牌号：</p>
                <input name="carnum" id="carnum" type="text">
                <em id="carnum_em" style="color: red; display: none;">完整车牌号不能为空</em>
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务日期：</p>
                <input name="bookTime[]" id="bookTimeDay"  type="date">
                <em id="bookTimeDay_em" style="color: red; display: none;">服务日期不能为空</em>
            </li>
            <li>
                <p class="p1"><span class="sp1">*</span>服务时间段：</p>
                <select name="bookTime[]" id="bookTimeHour">
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
                <textarea name="remark" id="remark"><?php echo $remark; ?></textarea>
            </div>
        </div>
        <div class="k">
            <p class="re">商品名称：  <?php echo $autoName; ?>  上门保养 </p>
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
                            <?php foreach ($products as $row) { ?>
                            <tr>
                                <td>[  <?php echo $row['category']; ?>  ]&nbsp;  <?php echo $row['product']; ?></td>
                            </tr>
                            <?php } ?>
                            <tr><td>服务费</td></tr>
                            </tbody>
                        </table>
                    </th>
                    <th>
                        <table>
                            <tbody>

                            <?php foreach ($orderDataId as $row) { ?>
                            <tr>
                                <td><?php echo $row['price']; ?></td>
                            </tr>
                            <?php } ?>
                            <tr><td><?php echo $fees; ?></td></tr>
                            </tbody>
                        </table>
                    </th>
                    <th class="pic">￥  <?php echo $total; ?></th>
                </tr>
                </tbody>
            </table>
        </div>
        <br><br>
        <div class="tj">
            <p class="z"> <b>当前费用：</b><span>￥  <?php echo $total; ?>  元</span><br>  支持现金、刷卡支付 </p>
            <p class="y">
                <input value="提交订单" type="submit">
            </p>
        </div>
    </div>
</form>
<script>
//    function checkForm(){
////        alert(1);
//        var array = ['name','mobile','address','carnum','bookTimeDay'];
////        alert(typeof array);
//
//        if($('#name').val()==''){
//            $('#name_em').html('姓名不能为空').show();
//        }else {
//            $('#name_em').hide();
//        }
//        return false;
//    }

    var memberAddressForm = {

        check: function (id) {
            if ($.trim($("#" + id)[0].value) == '') {
                $("#" + id)[0].focus();
                $("#" + id + "_em").show();
                return false;
            }else{
                $("#" + id + "_em").hide();
            }
            return true;
        },

        validate: function () {



            if (memberAddressForm.check("name") == false) {
                return false;
            }
            if (memberAddressForm.check("mobile") == false) {
                return false;
            }
            if (memberAddressForm.check("address") == false) {
                return false;
            }
            if (memberAddressForm.check("carnum") == false) {
                return false;
            }
            if (memberAddressForm.check("bookTimeDay") == false) {
                return false;
            }
            $('#submit').prop('disabled','disabled');

            $("#form-order")[0].submit();

            return false;
        },

        submit: function () {


            return false;
        }
    };
</script>