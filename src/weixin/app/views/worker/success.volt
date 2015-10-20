<div class="Xd">
    <h2 class="t">
        <em><a href="/worker/dashboard">&lt;首页</a></em>友情提示
    </h2>
    <p class="ts"><span>提交成功</span></p>
    <p><span><em id="seconds">5</em> 秒后自动跳转至工作台。</span></p>
</div>
<script>
    setTimeout(function(){
//        window.location.href="/worker/dashboard";
    },5000);

    setInterval(function () {
        var obj = $('#seconds');
        var seconds = parseInt(obj.html());
        if(seconds>0){
            seconds--;
            obj.html(seconds);
        }else{
            window.location.href="/worker/dashboard";
        }
    },1000);
</script>
