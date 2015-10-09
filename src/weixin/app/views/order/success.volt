<div class="Xd">
    <h2 class="t">
        <em><a href="/index/index">&lt;首页</a></em>友情提示
    </h2>
    <p class="ts"><span>预约成功</span></p>
    <p><span>您的养车预约确认中..<em id="seconds">3</em> 秒后自动跳转至首页。</span></p>
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
