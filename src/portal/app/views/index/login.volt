<div class="title">
    <p>
        会员登录
    </p>
</div>
<div class="login">
    <form action="" method="post">
        {{flash.output()}}
        <p><input type="text" placeholder="请输入电话" name="mobile" id="mobile"></p>
        <p><input type="text" placeholder="请输入验证码" name="code"></p>
        <p><input type="button" value="获取验证码" class="getCode"></p>
        <input type="hidden"  name="{{this.security.getTokenKey()}}" value="{{this.security.getToken()}}">

        <p class="sub">
            <input type="submit" value="登录">
        </p>
    </form>
</div>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script>
    var send = $('.getCode'),interval = null;
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
    $('.getCode').click(function(){
        var mobile =$('#mobile').val();
        if(!mobile){
            alert('请输入电话');return  false;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {mobile: mobile},
            url:  'getcode',
            success: function (data) {
                $.cookie('sms', new Date().getTime());
                intervalSend();
            }
        });
    })
</script>
