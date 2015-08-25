<form action="/e/ShopSys/CarOrder/shouji.php" method="post" id="startyyue">
    <input name="xm" id="xm" value="" type="hidden">
    <input name="pagecid" value="35" type="hidden">
    <input name="pageid" value="284" type="hidden">

    <div class="Sh">
        <h2 class="t"><em><a href="/">&lt;首页</a></em>选择服务项目</h2>

        <h1 class="name">奥迪(进口) A8L 上门保养</h1>
        <input name="title" value="奥迪(进口) A8L 上门保养" type="hidden">
        <input name="carclassid" value="44" type="hidden">
        <input name="carid" value="359" type="hidden">
        <input name="cartitle" value="sDrive18i  2.0L_2012.03-2015" type="hidden">

        <p class="pre">价格：<span>￥1215元</span></p>

        <p class="xm">项目：</p>
        <ul class="m">
            <li>
                <p class="p1">
                    <label>
                        <input name="jiyouche" checked="checked" onclick="ChePre();" type="checkbox"><span>机油</span>
                    </label>
                </p>

                <p class="p2">
                    <select name="jiyou" onchange="check(this);" id="jiyou">
                        <option value="265-496.00-嘉实多磁护 5W-40 SN/CF 7L[￥496.00]">嘉实多磁护 5W-40 SN/CF 7L[￥496.00]</option>
                        <option value="266-560.00-嘉实多极护全合成 0w-40 SN/CF 7L[￥560.00]">嘉实多极护全合成 0w-40 SN/CF 7L[￥560.00]</option>
                        <option value="267-624.00-美孚1号金装全合成 0W-40 SN/CF 7L[￥624.00]">美孚1号金装全合成 0W-40 SN/CF 7L[￥624.00]</option>
                        <option value="269-528.00-壳牌超凡灰喜力全合成 5W-40 SN/CF 7L[￥528.00]">壳牌超凡灰喜力全合成 5W-40 SN/CF 7L[￥528.00]</option>
                        <option value="264-290.00-嘉实多金嘉护 SN 10W-40 7L[￥290.00]">嘉实多金嘉护 SN 10W-40 7L[￥290.00]</option>
                    </select>
                </p>
            </li>
            <li>
                <p class="p1">
                    <label>
                        <input name="jilvche" checked="checked" onclick="ChePre();" type="checkbox"><span>机油滤清器</span>
                    </label>
                </p>

                <p class="p2">
                    <select name="jilv" onchange="check(this);" id="jilv">
                        <option value="1298-139.00-暂无库存[￥139.00]">暂无库存[￥139.00]</option>
                    </select>
                </p>
            </li>
            <li>
                <p class="p1">
                    <label>
                        <input name="kongqiche" checked="checked" onclick="ChePre();" type="checkbox"><span>空气滤清器</span>
                    </label>
                </p>

                <p class="p2">
                    <select name="kongqi" onchange="check(this);" id="kongqi">
                        <option value="1299-200.00-暂无库存[￥200.00]">暂无库存[￥200.00]</option>
                    </select>
                </p>
            </li>
            <li>
                <p class="p1">
                    <label>
                        <input name="kongtiaoche" checked="checked" onclick="ChePre();" type="checkbox"><span>空调滤清器</span>
                    </label>
                </p>

                <p class="p2">
                    <select name="kongtiao" onchange="check(this);" id="kongtiao">
                        <option value="1300-230.00-暂无库存[￥230.00]">暂无库存[￥230.00]</option>
                    </select>
                </p>
            </li>
        </ul>
        <p class="server">
            <label onclick="alert('服务费是必选项,无法取消！');return false;">
                <input name="" value="1" checked="checked" type="checkbox">
                <span>服务费￥150.00元</span>
            </label>
        </p>

        <p class="other">
            其它：
            <label>
                <input name="other" id="qita" type="checkbox">
                <span>已有配件，仅购买上门服务</span>
            </label>
        </p>

        <p class="xia">
            <input value="下一步" id="btn_step2" type="submit">
        </p>
    </div>
</form>
<script type="text/javascript">

    var mleng = $('.Sh .m select').length;
    //计算价格
    function ChePre() {
        var pre = 150;
        for (i = 0; i < mleng; i++) {
            var obj = $('.Sh .m select').eq(i);
            if ($('.Sh .m input').eq(i).attr('checked')) {
                var val = obj.val();
                s = val.split("-");
                pre += parseInt(s[1]);
            }

        }
        $('.pre span').html('￥' + pre + '元');
    }
    ChePre();


    $("#btn_step2").click(function () {
        var p = "";
        var jiyou = $("#jiyou").val().split("-");
        p += "13:" + jiyou[0] + ",";
        var jilv = $("#jilv").val().split("-");
        p += "30:" + jilv[0] + ",";
        var kongqi = $("#kongqi").val().split("-");
        p += "58:" + kongqi[0] + ",";
        var kongtiao = $("#kongtiao").val().split("-");
        p += "60:" + kongtiao[0] + ",";

        if ($("#qita").is(':checked') == true) {
            p = "59:207";
        }
        else {
            p += "59:207";
        }

        if ("" == p) {
            alert("请选择预约项目!");
            return false;
        }
        $("#xm").val(p);
        $("#startyyue").submit();
    });


    //下拉框值变的时候
    function check(obj) {
        if ($(obj).parent().prev().find('input').attr('checked') == false) {
            alert('请先取消掉已有配件，仅上门服务！');
            return false;
        }
        ChePre();
    }

    //仅上门服务的时候
    $('.Sh .other input').click(function () {
        if ($(this).attr('checked')) {
            $('.Sh .m input').removeAttr("checked");
        } else {
            $('.Sh .m input').attr('checked', 'checked');
        }
        ChePre();
    })
</script>
