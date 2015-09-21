<style>
    .alert-danger {
        border: 1px solid #fadb4b;
        background:#ffffcc;
        color: #ff9900;
        font-size: 13px;
        height: 38px;
        line-height: 38px;
        text-align:center;
        width: 80%;
        margin-left: 10%;
    }
</style>
<div class="title">
    <p>
        会员登录
    </p>
</div>
<div class="login">
    <p>{{flash.output()}}</p>

    <form action="" method="post">

        <p><input type="text" placeholder="请输入电话" name="mobile" id="mobile" maxlength="11"></p>

        <p class="yzm">
            <input type="text" maxlength="4" name="inputCode" id="inputCode" class="form-control" placeholder="图形验证码"
                   required="" style="width: 120px;">
            <img title="点击刷新" src="/index/captcha" align="absbottom"
                 onclick="this.src='/index/captcha?'+Math.random();"/>
        </p>

        <p class="yzm">
            <input type="text" placeholder="短信验证码" name="code" style="width: 120px;">
            <input type="button" value="获取验证码" class="getCode" style="width: 200px;text-align: center;margin-left: 30px;">
        </p>


        <input type="hidden" name="{{this.security.getTokenKey()}}" value="{{this.security.getToken()}}">

        <p class="sub">
            <input type="submit" value="登录">
        </p>
    </form>
</div>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script>
    var send = $('.getCode'), interval = null;
    function intervalSend() {
        var time = new Date().getTime(),
            sms = $.cookie('sms') || 0,
            span = parseInt((time - sms) / 1000);

        if (sms < 1 || span >= 60) {
            send.removeAttr('disabled').val('获取验证码');
            send.addClass('getcode');
            if (interval) {
                clearInterval(interval);
                interval = null;
            }

        } else {
            send.attr('disabled', 'disabled');

            send.val((60 - span) + '秒内请查看短信');
            send.removeClass('getcode');

            if (!interval) {
                interval = setInterval(function () {
                    intervalSend();
                }, 1000);
            }
        }
    }
    intervalSend();
    $('.getCode').click(function () {
        var mobile = $('#mobile').val();
        var captcha = $('#inputCode').val();
        if (!mobile) {
            alert('请输入电话');
            return false;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {mobile: mobile, captcha: captcha},
            url: '/index/getcode',
            success: function (data) {
                if (data.statusCode != '000000') {
                    alert(data.statusMsg);
                } else {
                    $.cookie('sms', new Date().getTime());
                    intervalSend();
                }
            }
        });
    });
</script>


