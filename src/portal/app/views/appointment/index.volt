<style>
    body {
        background: url('/assets/images/bg2.jpg');
    }

</style>
<img src="{{url('assets/images/phone.png')}}">
400-023-6621
</div>
</div>

</div>
<div class="content">


    <div class="by1">
        <div class="center" style="background:#fff;">
            <div class="cfont" style="margin-top:30px">
                <h1>1</h1>

                <div class="cfxz" style="background:url(/i/ccc.png) no-repeat left center;width:250px;text-indent:34px">
                    选择车型，查询报价

                </div>
            </div>
            <div class="byc">
                <div class="byi">
                    <div class="rmcx">选择品牌</div>
                    <ul id="pc-chars">
                        {% for row in a_z%}
                        <li><a href="#label">{{row}}</a></li>
                        {% endfor %}
                    </ul>
                </div>

                <div class="byxz">
                    <div class="main js_main">
                        <ul>
                            <li>

                                <input type="text" value="品牌" readonly name="pin"/>
                                <ul style="text-align: left;" class="m" jq-area="CarBrand">
                                    {% for row in a_z%}
                                    {% set i=0%}
                                    {% for brand in brands %}
                                    {% if brand.initials == row %}
                                    {% if i == 0 %}
                                    <li style="text-align: left;" data-bcid={{ brand.id }} data-type="1"><b>{{row}}</b><em>{{ brand.name }}</em>
                                    </li>
                                    {% else %}
                                    <li style="text-align: left;" data-bcid={{ brand.id }} data-type="1">&nbsp;&nbsp;&nbsp;&nbsp;<em>{{ brand.name
                                            }}</em></li>
                                    {% endif %}
                                    {% set i+=1%}
                                    {% endif %}
                                    {% endfor %}
                                    {% endfor %}
                                </ul>
                            </li>
                            <li >

                                <input type="text" value="系列" readonly name="che"/>
                                <ul style="text-align: left;" class="m" jq-area="Car-1">


                                </ul>
                            </li>
                            <li>

                                <input type="text" value="型号" readonly name="kuan"/>
                                <ul style="text-align: left;" class="m" jq-area="Car-2"></ul>
                            </li>
                        </ul>

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
            <p style="width:80%;overflow:hidden"><a style="font-size:12px;color:#999;float:right;" href="/appointment/notauto">未找到车型？</a></p>

            <div class="d"><a href="javascript:void(0);" id="btn">下一步</a></div>
        </div>
    </div>
</div>
</div>
