<style>
    body{background:url(/images/bg2.jpg)}
    .jq-hide{display:none;}
    .pc-pname{position:absolute;z-index:20;width: 70px;height: 30px;line-height: 30px;font-size: 16px;color: #888;}
    .pc-pi{padding:6px 8px;}
    .pc-active{ background: #FF5416 !important;color: #fff;}
</style>
<div style="min-height: 494px;" class="content">
<div style="background:#fff;margin-top:20px" class="center">
<div class="cfont">
    <h1>2</h1>

    <div class="cfxz">选择服务</div>
</div>
<form id="startyyue" action="/e/ShopSys/CarOrder/" method="post">
    <input type="hidden" value="13:251,30:811,58:812,60:813,59:207" id="xm" name="xm">
    <input type="hidden" value="48" name="pagecid">
    <input type="hidden" value="289" name="pageid">

    <div class="hl">
        <div class="main">
            <div style="margin:0 auto; text-align:center" id="protypelist">
                <a class="pc-pi pc-active" jq-index="200000" href="javascript:;" id="on">机油三滤</a>
                <a class="pc-pi pc-active" jq-index="200001" href="javascript:;" id="on">机油机滤</a>
                <a class="pc-pi pc-active" jq-index="200002" href="javascript:;" id="on">空调过滤清洗</a>
                <a class="pc-pi pc-active" jq-index="200003" href="javascript:;" id="on">发动机舱清洗</a>
                <a class="pc-pi pc-active" jq-index="200004" href="javascript:;" id="on">换胎服务</a>
            </div>
            <div class="nd">
                <p class="p4">奥迪(一汽) A4 上门保养</p>
                <ul class="m js">
                    <span class="pc-pname">项目：</span>
                    <li jq-index="200000" class="jq-hide" style="display: list-item;">
                        <span class="p1">&nbsp;</span>
                        <label>
                            <input type="checkbox" jq-price="353.00" jq-act="jiyou" jq-pid="13" jq-id="252" jq-checked="1">机油
                        </label>
                        <input type="text" readonly="" title="嘉实多磁护 5W-40 [￥353.0]" value="嘉实多金嘉护 SN 10W-40[￥174.0]" class="text">
                        <ul jq-type="jiyou" class="er" style="display: none;">
                            <li data-price="174.00" data-id="251">嘉实多金嘉护 SN 10W-40[￥174.0]</li>
                            <li data-price="353.00" data-id="252">嘉实多磁护 5W-40 [￥353.0]</li>
                            <li data-price="467.00" data-id="253">嘉实多极护全合成 0W-40 [￥467.0]</li>
                            <li data-price="541.00" data-id="254">美孚1号金装全合成 0W-40 [￥541.0]</li>
                            <li data-price="200.00" data-id="255">壳牌黄喜力HX5 10W-40 [￥200.0]</li>
                            <li data-price="485.00" data-id="256">壳牌超凡灰喜力全合成 5W-40 [￥485.0]</li>
                        </ul>
                    </li>
                    <li jq-index="200000" class="jq-hide" style="display: list-item;">
                        <span class="p1">&nbsp;</span>
                        <label>
                            <input type="checkbox" jq-price="25.00" jq-act="jilv" jq-pid="30" jq-id="811" jq-checked="1">机油滤清器
                        </label>
                        <input type="text" readonly="" title="马勒[￥25.0]" value="马勒[￥25.0]" class="text">
                        <ul jq-type="jilv" class="er" style="display: none;">
                            <li data-price="25.00" data-id="811">马勒[￥25.0]</li>
                            <li data-price="40.00" data-id="307">曼牌[￥40.0]</li>
                        </ul>
                    </li>
                    <li jq-index="200000" class="jq-hide" style="display: list-item;">
                        <span class="p1">&nbsp;</span>
                        <label>
                            <input type="checkbox" jq-price="60.00" jq-act="kongqi" jq-pid="58" jq-id="404" jq-checked="1">空气滤清器
                        </label>
                        <input type="text" readonly="" title="曼牌[￥60.0]" value="马勒[￥69.0]" class="text">
                        <ul jq-type="kongqi" class="er" style="display: none;">
                            <li data-price="69.00" data-id="812">马勒[￥69.0]</li>
                            <li data-price="60.00" data-id="404">曼牌[￥60.0]</li>
                        </ul>
                    </li>
                    <li jq-index="200000" class="jq-hide" style="display: list-item;">
                        <span class="p1">&nbsp;</span>
                        <label>
                            <input type="checkbox" jq-price="135.00" jq-act="kongtiao" jq-pid="60" jq-id="405" jq-checked="1">空调滤清器
                        </label>
                        <input type="text" readonly="" title="曼牌活性炭空调滤清器[￥135.0]" value="马勒活性炭空调滤清器[￥89.0]" class="text">
                        <ul jq-type="kongtiao" class="er" style="display: none;">
                            <li data-price="89.00" data-id="813">马勒活性炭空调滤清器[￥89.0]</li>
                            <li data-price="135.00" data-id="405">曼牌活性炭空调滤清器[￥135.0]</li>
                        </ul>
                    </li>
                    <li id="projectlastli">
                        <span class="p1">&nbsp;</span>
                        <label>
                            <input type="checkbox" jq-price="150" jq-act="qita" jq-checked="1" jq-pid="59" jq-id="207" onclick="alert('服务费是必选项，无法取消');return false;" checked="checked" disabled="disabled">服务费<span id="jq-id-price">150</span>
                        </label>
                    </li>
                    <li class="li">
                        <span class="p1">其它：</span>
                        <label>
                            <input type="checkbox" jq-price="0" jq-checked="0" id="onlyqita" name="">已有配件，仅购买上门服务
                        </label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ppp">
            <div class="next"><input type="submit" class="y" value="下一步" id="btn_step2"></div>
            <p class="p2"><span id="realprice" class="p3">723</span>元</p>
            <span class="p1">价格：</span>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function () {
        $('.js .text').click(function () {
            if ($(this).parent().find('input').attr('checked')) {
                $(this).next().slideDown(150);
            } else {
                alert('还没有选择此项服务！');
            }
        });

        $('.js li').mouseleave(function () {
            $(this).find('.er').slideUp(150);
        });

        $('.js li ul').mouseleave(function () {
            $(this).slideUp(150);
        });

        $('.js li ul li').click(function () {
            var value = $(this).text();
            $(this).parent().prev().val(value);
            $(this).parent().slideUp(150);
        });

        var price = {jiyou: 0, jilv: 0, kongqi: 0, kongtiao: 0, jicang: 0, guandao: 0, huohua: 0, ranyou: 0, dianping: 0, qita: 0};
        var $hli = $("ul.js").find("li.jq-hide"),
            $onlyqita = $("#onlyqita"),
            servid = pChen.intval(pChen.getUrlVal("servid", "200000"), 200000),
            $qita = $("#projectlastli input"),
            $protypelist = $("#protypelist").children();
        var setSelectStatue = function (index, i) {
            index = pChen.intval(index, 200000);
            if (0 === i) {
                if (200000 === index &amp;&amp; $hli.filter("[jq-index='" + index + "']:visible").size() &gt; 0) {
                    return false;
                }
                $protypelist.filter("[jq-index='" + index + "']").removeClass("pc-active");
            } else {
                $protypelist.filter("[jq-index='" + index + "']").addClass("pc-active");
            }
        };
        var resumprice = function () {
            var p = 0, fwf = 150, fwid = 207;//pChen.intval($qita.attr("jq-price"),150);
            if ($hli.filter(":visible").size() &gt; 1 || "200003" != $hli.filter(":visible").attr("jq-index")) {
                fwf = 150;
                fwid = 207
            } else {
                fwf = 80;
                fwid = 1523;
            }
            $qita.attr("jq-price", fwf).attr("jq-id", fwid);
            $("#jq-id-price").text(fwf);

            for (var i in price) {
                price[i] = parseInt(price[i]) || 0;
                p += price[i];
            }
            p += fwf;
            $("#realprice").text(p);
        }
        //resumprice();

        $("#btn_step2").click(function () {
            var p = a = "";
            $("input[jq-act]").each(function () {
                var obj = $(this), bChk = parseInt(obj.attr("jq-checked")) || 0, type = parseInt(obj.attr("jq-pid")) || 0;
                if (bChk) {
                    p += a + type + ":" + obj.attr("jq-id");
                    a = ",";
                }
            });
            if ("" == p) {
                alert("请选择预约项目!");
                return false;
            }
            $("#xm").val(p);
            $("#startyyue").submit();
        });

        $onlyqita.click(function () {
            var pl = $("#protypelist").children(".pc-active");
            if (pl.size() &gt; 1 || (1 === pl.size() &amp;&amp; 0 === pl.filter("[jq-index='200000']").size())) {
                alert("仅“机油三滤”才可勾选此项！");
                return false;
            }
            var obj = $(this), bChk = parseInt(obj.attr("jq-checked")) || 0;
            if (bChk) {
                obj.attr("jq-checked", 0);
            } else {
                obj.attr("jq-checked", 1);
                $("input[jq-act]").each(function () {
                    var that = $(this);
                    if (that.attr("checked") &amp;&amp; "qita" != that.attr("jq-act")) {
                        that.attr("jq-checked", 0);
                        that.attr("checked", false);
                        var $li = that.parent().parent(), index = 0;
                        if ($li.hasClass("jq-hide")) {
                            index = $li.attr("jq-index");
                            $li.hide();
                            setSelectStatue(index, 0);
                        }
                    }
                });
                for (var i in price) {
                    price[i] = 0;
                }
                //price.qita=obj.attr("jq-price");
                resumprice();
            }
        });

        $("input[jq-act]").click(function () {//div
            if ($onlyqita.attr('checked')) {
                alert('请先取消“已有配件，仅购买上门服务”！');
                return false;
            }
            var obj = $(this), type = obj.attr("jq-act"), bChk = parseInt(obj.attr("jq-checked")) || 0;
            if (type == "qita") {
                return false;
            }
            if (bChk) {//已选中,准备取消.
                obj.attr("jq-checked", 0);
                price[type] = 0;
                var $li = obj.parent().parent(), index = 0;
                if ($li.hasClass("jq-hide")) {
                    index = $li.attr("jq-index");
                    $li.hide();
                    setSelectStatue(index, 0);
                }
            } else {
                obj.attr("jq-checked", 1);
                price[type] = obj.attr("jq-price");
                /*if($onlyqita.attr('checked')){
                 $onlyqita.attr("jq-checked",0);
                 }*/
            }
            resumprice();
        });

        $('.js li .er li').click(function () {
            var value = $(this).text(), type = $(this).parent().attr("jq-type");
            $(this).parent().prev().val(value).attr("title", value);
            $(this).parent().slideUp(200);
            var m = $("input[jq-act='" + type + "']");
            m.attr("jq-price", $(this).attr("data-price"));
            m.attr("jq-id", $(this).attr("data-id"));
            price[type] = $(this).attr("data-price");
            resumprice();
            return false;
        });

        $protypelist.click(function () {
            if ($onlyqita.attr('checked')) {
                alert('请先取消“已有配件，仅购买上门服务”！');
                return false;
            }
            var that = $(this), index = that.attr("jq-index"), bsel = that.hasClass("pc-active");
            if (!bsel) {//准备选中
                $hli.filter("[jq-index='" + index + "']").show().find("input[jq-act]").attr("jq-checked", 0).attr("checked", false).trigger("click");
                setSelectStatue(index, 1);
            } else {//即将取消
                $hli.filter("[jq-index='" + index + "']").hide().find("input[jq-act]").attr("jq-checked", 1).attr("checked", true).trigger("click");
                setSelectStatue(index, 0);
            }
            return false;
        });
        if (servid &gt; 200005 || servid &lt; 200001) {
            servid = 200000;
        }
        $protypelist.filter("[jq-index='" + servid + "']").trigger("click");
    })
</script>
</div>
</div>
