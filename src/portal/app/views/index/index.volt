<div class="content">

    <div class="fullSlide">
        <div class="bd">
            <ul>
                <li style="background:#fff url(/assets/data-pic/banner1.jpg) center 0 no-repeat;">
                    <a href="#" target="_blank"></a>
                </li>
                <li style="background:#fff url(/assets/data-pic/banner3.jpg) center 0 no-repeat;">
                    <a href="#" target="_blank"></a>
                </li>
                <li style="background:#fff url(/assets/data-pic/banner2.jpg) center 0 no-repeat;">
                    <a href="#" target="_blank"></a>
                </li>
            </ul>
        </div>

        <span class="prev"></span> <span class="next"></span>
    </div>

    <div class="by">

        <div class="byc">
            <div class="byi">
                <a name="label"></a>

                <div class="rmcx">选择品牌</div>
                <ul id="pc-chars">
                    {% for row in a_z%}
                    <li><a href="#label">{{row}}</a></li>
                    {% endfor %}

                </ul>
            </div>


            <div class="byxz">

                <div class="center">
                    <div class="main js_main">
                        <ul>
                            <li>

                                <input type="text" value="品牌" readonly name="pin"/>
                                <ul class="m" jq-area="CarBrand">
                                    {% for row in a_z%}
                                    {% set i=0%}
                                    {% for brand in brands %}
                                    {% if brand.initials == row %}
                                    {% if i == 0 %}
                                    <li data-bcid={{ brand.id }} data-type="1"><b>{{row}}</b><em>{{ brand.name }}</em>
                                    </li>
                                    {% else %}
                                    <li data-bcid={{ brand.id }} data-type="1">&nbsp;&nbsp;&nbsp;&nbsp;<em>{{ brand.name
                                            }}</em></li>
                                    {% endif %}
                                    {% set i+=1%}
                                    {% endif %}
                                    {% endfor %}
                                    {% endfor %}
                                </ul>

                            </li>
                            <li>

                                <input type="text" value="系列" readonly name="che"/>
                                <ul class="m" jq-area="Car-1">

                                </ul>
                            </li>
                            <li>

                                <input type="text" value="型号" readonly name="kuan"/>
                                <ul class="m" jq-area="Car-2"></ul>
                            </li>
                        </ul>
                        <div class="d"><a href="javascript:void(0);" id="btn">下一步</a></div>
                    </div>
                </div>

            </div>
            <script type="text/javascript">
                //解决js兼容问题；
                jQuery(function ($) {
                    var $chars = $("#pc-chars"), $carbrand = $("ul[jq-area='CarBrand']");
                    $carbrand.scrollTop(0).show();
                    var last = '';
                    $chars.children().each(function () {
                        var that = $(this), c = that.text();
                        var position = $carbrand.find("li>b:contains('" + c + "')");
                        var t = '';
                        if (null != position.parent().position()) {
                            last = position.parent().position().top;
                            t = last;
                        } else {
                            t = last;
                        }

                        that.data("offsetY", t).bind("click", function () {
                            $carbrand.show().scrollTop($(this).data("offsetY"));
                        });
                    });
                    $carbrand.hide();
                });
                var ha = $('.js_main');
                ha.find('input').click(function () {
                    $(this).next().slideDown(100);
                })

                ha.find('.m').mouseleave(function () {
                    $(this).slideUp(100);
                })


                jQuery(function ($) {
                    var yyUrl = "";
                    $(".js_main .m").delegate("li[data-type]", "click", function () {
                        var that = $(this), bcid = pChen.intval(that.attr("data-bcid")), type = pChen.intval(that.attr("data-type")), value = that.text();
                        value = that.find('em').text();
                        yyUrl = "";
                        if (0 >= bcid || 0 >= type) return false;

                        that.parent().prev().val(value);
                        that.parent().slideUp(150);
                        if (3 === type) {
                            yyUrl = that.attr("data-url");
                            return false;
                        }
                        $.post("/index/getauto", {"cid": bcid, "method": type}, function (data) {
                            var json = pChen.parseJson(data);
                            if (1 == json.status) {
                                var t = "";
                                $.each(json.msg, function (i, r) {
                                    t += '<li data-bcid="' + r.id + '" data-type="' + (type + 1) + '" data-url="' + r.url + '"><em>' + r.title + '</em></li>';
                                });
                                if (type == 2) {
                                    t += '<li data-bcid="10086" data-type="3" data-url="appointment/notauto"><em>没有找到自己的车型款式</em></li>';
                                }
                                $("ul[jq-area='Car-" + type + "']").html(t).prev().val("请选择！");
                            } else {
                                $("ul[jq-area='Car-" + type + "']").empty().prev().val("请选择！");
                            }
                        });
                        return false;

                    });

                    $("#btn").click(function () {
                        if (pChen.empty(yyUrl, 1)) {
                            alert("请选择要预约的品牌,车型以及款式");
                            return false;
                        }
                        window.location.href = yyUrl;
                    });
                })
            </script>
        </div>

    </div>
    <div class="center">
        <div class="fw">
            <h1>我们的服务</h1>
            <ul>
                <li>
                    <a href="/introduction/oilfilter"><img src="{{url('/assets/images/jy.jpg')}}"></a>
                    <p>机油三滤</p>
                    <span>更换机油、机滤、空气滤、空调滤及32项全车检测</span>
                </li>
                <li>
                    <a href="/introduction/filter"><img src="{{url('/assets/images/jy22.jpg')}}"></a>
                    <p>机油机滤</p>
                    <span>去除机油中的灰尘、金属颗粒、碳沉淀物和煤烟颗粒等杂质，保护发动机。</span>
                </li>
                <li>
                    <a href="/introduction/airconditioner"><img src="{{url('/assets/images/jy55.jpg')}}"></a>
                    <p>空调过滤清洗</p>
                    <span>空调管道清洗，还您健康、清新的空气</span>
                </li>
                <li>
                    <a href="/introduction/engine"><img src="{{url('/assets/images/jy33.jpg')}}"></a>
                    <p>发动机舱清洗</p>
                    <span>专业清洗发动机舱，延长爱车寿命</span>
                </li>
                <li>
                    <a href="/introduction/tires"><img src="{{url('/assets/images/jy44.jpg')}}"></a>
                    <p>换胎服务</p>
                    <span>更换轮胎，解您燃眉之急</span>
                </li>


            </ul>

        </div>


    </div>

    <div class="syb">
        <div class="syb1">
            <div class="syb2">
                <div class="zc">
                    <h1>服务支持</h1>
                    <a href="{{url('/appointment/notauto')}}">未找到车型</a>
                    <a href="63.html">产品保证</a>
                    <a href="{{url('/introduction')}}">服务说明</a>
                    <a href="61.html">售后政策</a>
                </div>
                <div class="zc">
                    <h1>关于我们</h1>
                    <a href="{{url('/about/contact')}}">联系我们</a>
                    <a href="{{url('/about/cooperation')}}">合作伙伴</a>
                    <a href="{{url('/about')}}">公司简介</a>
                </div>
                <div class="zc" style="width:350px">
                    <h1>联系我们</h1>
                    <a><img src="/assets/images/tel.png">400 - 023 - 6621</a>
                    <a><img src="/assets/images/wz.png" style="margin-right:12px;margin-left:3px">重庆市渝北区宝石路14号6栋-1-20</a>
                    <a><img src="/assets/images/qq.png">2546698866</a>
                    <a><img src="/assets/images/wx.png">handao365</a>
                </div>


            </div>
            <div class="syb3">
                <img src="images/ewm.jpg">

            </div>
        </div>


    </div>


</div>
<script type="text/javascript">
    jQuery(".fullSlide").hover(function () {
            jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 1)
        },
        function () {

        });
    jQuery(".fullSlide").slide({
        titCell: ".hd ul",
        mainCell: ".bd ul",
        effect: "fold",
        autoPlay: true,
        autoPage: true,
        trigger: "click",
        startFun: function (i) {
            var curLi = jQuery(".fullSlide .bd li").eq(i);
            if (!!curLi.attr("_src")) {
                curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
            }
        }
    });
</script>
