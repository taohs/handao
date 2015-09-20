<style>
    body {
        background: url('/assets/images/bg2.jpg');
    }
    .jq-hide{display:none;}
    .pc-pname{position:absolute;z-index:20;width: 70px;height: 30px;line-height: 30px;font-size: 16px;color: #888;}
    .pc-pi{padding:6px 8px;}
    .pc-active{ background: #FF5416 !important;color: #fff;}
</style>

<div class="content" style="min-height: 232px;">
    <div class="center success" style="background:#fff;margin-top:20px">
        <p class="tip1 right"><span>预约成功</span></p>
        <p class="tip2">您的养车预约确认中...<em id="seconds">5</em> 秒后自动跳转至首页。</p>
    </div>
</div>
<script>
    setTimeout(function(){
        window.location.href="/index/index";
    },5000);

    setInterval(function () {
        var obj = $('#seconds');
        var seconds = parseInt(obj.html());
        if(seconds>0){
            seconds--;
            obj.html(seconds);
        }else{
            window.location.href="/index/index";
        }
    },1000);
</script>
