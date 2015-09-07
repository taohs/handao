<style>
    body {
        background: url(/images/bg2.jpg)
    }

    .jq-hide {
        display: none;
    }

    .pc-pname {
        position: absolute;
        z-index: 20;
        width: 70px;
        height: 30px;
        line-height: 30px;
        font-size: 16px;
        color: #888;
    }

    .pc-pi {
        padding: 6px 8px;
    }

    .pc-active {
        background: #FF5416 !important;
        color: #fff;
    }
</style>
<div class="content" style="min-height: 232px;">
    <div class="center" style="background:#fff;margin-top:20px">
        <div class="cfont">
            <h1>2</h1>

            <div class="cfxz">选择服务</div>
        </div>
        <form method="post" action="/appointment/order" id="startyyue">
            <input type="hidden" name="models_id" value="{{models.id}}">
            <input type="hidden" name="autoName" value="{{brands.name}} {{models.name}}">

            <div class="hl">
                <div class="main">
                    <div id="protypelist" style="margin:0 auto; text-align:center">
                        {% set i=0 %}
                        {% for cate in category %}

                        <a href="javascript:;" jq-index="{{200000+i}}" class="pc-pi " >{{cate.name}}</a>
                        {% set i+=1 %}
                        {% endfor %}
                    </div>
                    <div class="nd">
                        <p class="p4">{{brands.name}} {{models.name}} 上门保养</p>
                        <ul class="m js">
                            <span class="pc-pname">项目：</span>
                            {% set i=0 %}
                            {% for cate in category %}
                            {% for ca in cates %}
                            {% if cate.id==ca.parent_id %}
                            <li style="display: list-item;" class="jq-hide" jq-index="200000">
                                <span class="p1">&nbsp;</span>
                                <label>
                                    <input jq-checked="1" jq-id="252" jq-pid="13" jq-act="jiyou" jq-price="0"
                                           type="checkbox" class="category" id="{{ca.id}}">{{ca.name}}
                                    <input value="" type="hidden" name="products[]" class="products">


                                </label>

                                <input class="text" value="请选择" title="请选择" readonly type="text">

                                <ul style="display: none;" class="er" jq-type="jiyou">
                                    {% for row in product %}
                                    {% if ca.id==row['category'] %}
                                    <li data-id="{{row['id']}}" data-price="{{row['member_price']}}"
                                        data-data="{{row['member_price']}}-{{row['id']}}-{{ca.id}}-{{ca.name}}-{{row['name']}}">{{row['name']}}[￥{{row['member_price']}}]
                                    </li>
                                    {%endif%}
                                    {% endfor %}

                                </ul>

                            </li>
                            {%endif%}
                            {% endfor %}
                            {% set i+=1 %}
                            {% endfor %}


                            <li id="projectlastli">
                                <span class="p1">&nbsp;</span>
                                <label>
                                    <input disabled="disabled" checked="checked"
                                           onclick="alert('服务费是必选项，无法取消');return false;" jq-id="207" jq-pid="59"
                                           jq-checked="1" jq-act="qita" jq-price="150" type="checkbox">服务费<span
                                        id="jq-id-price">150</span>
                                </label>
                            </li>
                            <li class="li">
                                <span class="p1">其它：</span>
                                <label>
                                    <input name="other" id="onlyqita" jq-checked="0" jq-price="0" type="checkbox">已有配件，仅购买上门服务
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ppp">
                    <div class="next"><input id="btn_step2" value="下一步" class="y" type="submit"></div>
                    <p class="p2"><span class="p3" id="realprice">150</span>元</p>
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

                var price = {
                    jiyou: 0,
                    jilv: 0,
                    kongqi: 0,
                    kongtiao: 0,
                    jicang: 0,
                    guandao: 0,
                    huohua: 0,
                    ranyou: 0,
                    dianping: 0,
                    qita: 0
                };
                var $hli = $("ul.js").find("li.jq-hide"),
                    $onlyqita = $("#onlyqita"),
                    servid = pChen.intval(pChen.getUrlVal("servid", "200000"), 200000),
                    $qita = $("#projectlastli input"),
                    $protypelist = $("#protypelist").children();
                var setSelectStatue = function (index, i) {
                    index = pChen.intval(index, 200000);

                    if (0 === i) {
                        if (200000 === index && $hli.filter("[jq-index='" + index + "']:visible").size() > 0) {
                            return false;
                        }
                        $protypelist.filter("[jq-index='" + index + "']").removeClass("pc-active");
                    } else {
                        $protypelist.filter("[jq-index='" + index + "']").addClass("pc-active");
                    }
                };
                var numberprice = 0;
                var resumprice = function () {
                    var p = 0, fwf = 150;



                    p = 0;

                    $('.category').each(function (i) {

                        if ($(this).attr('checked') && $(this).next().val()!="") {
//                            alert(parseFloat($(this).next().val()));
                            p += parseFloat($(this).next().val());
//
                        }
                    });


                    p += fwf;
//                    alert(numberprice);
                    $("#realprice").text(p);
//                    numberprice = 0;
                };
                //resumprice();

                $("#btn_step2").click(function () {
                    var p = a = "";

                    $('.category').each(function (i, n) {
                        if (!$(this)[0].checked) {
                            $(this).next('.products').attr('name', '');
                        } else {
                            $(this).next('.products').attr('name', 'products[]');
                        }
                    })


                    var products = $('.products').val();
                    if (!products) {
                        alert('请选择商品');
                        return false;
                    }
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
                    if (pl.size() > 1 || (1 === pl.size() && 0 === pl.filter("[jq-index='200000']").size())) {
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
                            if (that.attr("checked") && "qita" != that.attr("jq-act")) {
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

                    var value = $(this).text(),
                        type = $(this).parent().attr("jq-type"),
                        data_data = $(this).attr('data-data')
                        ;
                    $(this).parent().prevAll('label').children('.products').val(data_data);


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
                if (servid > 200005 || servid < 200001) {
                    servid = 200000;
                }
                $protypelist.filter("[jq-index='" + servid + "']").trigger("click");
            })
        </script>
    </div>
</div>
