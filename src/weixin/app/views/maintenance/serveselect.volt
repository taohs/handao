<script type="text/javascript">
    function checkForm() {


        var pnumber = 0;

        $('.s-title-price').each( function () {
            if($(this).html()!=''){
                var v=$ (this).html().split('￥');
                pnumber +=parseFloat(v[1]);
            }
        });


        var p = '';
        if ($("#qita").is(':checked')) {
            p = 1;
        }

        if (pnumber == 0 && p == 0) {
            alert("请选择预约项目!");
            return false;
        }
    }
</script>
<form action="/order" method="post" id="startyyue" onsubmit="return checkForm();">
    <div class="Sh">
        <h2 class="t"><em><a href="/">&lt;首页</a></em>选择服务项目</h2>

        <h1 class="name">{{brands.name}} {{models.name}} 上门保养</h1>

        <p class="pre">价格：<span>￥0元</span></p>
        <input type="hidden" name="models_id" value="{{models.id}}">
        <input type="hidden" name="modelsExact_id" value="{{modelsExact.id}}">
        <input type="hidden" name="autoName" value="{{brands.name}} {{models.name}} {{modelsExact.name}}">

        <p class="xm">项目：机油三滤</p>
        <div class="xzxm">

            {% for cate in category %}
            {% if productGroup[cate.id] is not empty %}

            <dl>
                <dt class="active">
                <p class="tup {{cutf8.encode(cate.name)}}">{{cate.name|e}}</p>

                <p class="nr-x">
                    <span class="s-title" featured="1" data-content="未选择{{cate.name|e}}">未选择{{cate.name|e}}</span>
                    <span class="s-title-price" data-content=""></span>
                    <input name="products[]" type="hidden" data-content="">
                </p>
                <a href="#">更换</a>
                </dt>




            {% for row in productGroup[cate.id] %}
            {% if productGroup[cate.id]|length >1 %}


                {%if loop.last%}
                    <dd class="dd-product"  featured="{{row['featured']}}">
                        <p>{{row['name']|e}} {#%if row['featured']%}<i>推荐</i>{%endif%#}</p>
                        <span> ￥{{row['member_price']|e}}</span>
                        <input type="hidden" data-content="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}" value="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}">
                    </dd>
                    <dd class="dd-cancel">
                        <a href="#" class="qx">取消选择</a>
                    </dd>

                {%else %}
                    <dd  class="dd-product"  featured="{{row['featured']}}">
                        <p>{{row['name']|e}} {#%if row['featured']%}<i>推荐</i>{%endif%#}</p>
                        <span> ￥{{row['member_price']|e}}</span>
                        <input type="hidden" data-content="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}" value="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}">

                    </dd>
                {%endif%}
            {%else%}
                <dd class="dd-product"  featured="{{row['featured']}}">
                    <p>{{row['name']|e}} {#%if row['featured']%}<i>推荐</i>{%endif%#}</p>
                    <span> ￥{{row['member_price']|e}}</span>
                    <input type="hidden" data-content="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}" value="{{row['member_price']}}-{{row['id']}}-{{cate.id}}-{{cate.name}}-{{row['name']}}">

                </dd>
                <dd class="dd-cancel">
                    <a href="#" class="qx">取消选择</a>
                </dd>
            {% endif%}
            {% endfor %}
            </dl>

            {%endif%}
            {% endfor %}

        </div>


        <p class="server">
            <label onclick="alert('服务费是必选项,无法取消！');return false;">
                <input name="server" value="{{fees}}" checked="checked" type="checkbox" readonly="readonly" disabled>
                <span>服务费￥{{fees}}元</span>
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
<script type="text/javascript" src="/assets/js/xial.js"></script>

<script type="text/javascript">

    var mleng = $('.Sh .m select').length;
    //计算价格
    function ChePre() {
        var pre = parseFloat("{{fees}}");
        $('.s-title-price').each( function () {
            if($(this).html()!=''){
                var v=$ (this).html().split('￥');
                pre +=parseFloat(v[1]);
            }
        });

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

        alert(jiyou);
        alert(p);
        if ($("#qita").is(':checked') == true) {
            p = "59:207";
        }
        else {
            p += "59:207";
        }
        alert(p);
        if ("" == p) {
            alert(p);
            alert("请选择预约项目!");
            return false;
        }
        $("#xm").val(p);

        return false;
    });


    //下拉框值变的时候
    function check(obj) {
        if ($(obj).parent().prev().find('input').attr('checked') == false) {
//            alert('请先取消掉已有配件，仅上门服务！');
            return false;
        }
        ChePre();
    }

    $('.category').change(function () {
        var pnumber = 0;

        $('.category').each(function (i, n) {

            if ($(this).is(':checked')) {
                pnumber++;
            }
        });

        if(pnumber){
            $('#qita').removeAttr("checked");
        }else{
            $('#qita').attr('checked', 'checked');
        }
    });

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
