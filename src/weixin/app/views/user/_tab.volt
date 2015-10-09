<div class="qh">
    <p class="choice">
        <a href="/user/index" {%if actionName=='index' or actionName=='edit'%} class="active" {%endif%}>个人信息</a>
        <a href="/user/wait"  {%if actionName=='wait'%} class="active" {%endif%}>待养护</a>
        <a href="/user/finish" {%if actionName=='finish'%} class="active" {%endif%}>已养护</a>
    </p>
</div>