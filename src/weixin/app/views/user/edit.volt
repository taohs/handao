{{partial('user/_head')}}
<style>
    input{
        height: 32px;
        width: 99%;
        border: 1px solid #ccc;
        font-size: 14px;
        text-indent: 10px;
    }
</style>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="/user/index" {%if actionName=='index'%} class="active" {%endif%}>个人信息</a>
            <a href="/user/wait"  {%if actionName=='wait'%} class="active" {%endif%}>待养护</a>
            <a href="/user/finish" {%if actionName=='finish'%} class="active" {%endif%}>已养护</a>
        </p>
    </div>
    <form method="post" action="">
    <div class="list show">


        <div class="info-wapper control-form" >
            <h1>个人信息
                <a href="/user/index" class="toUndo">返回</a>
            </h1>
            <ul class="clearfix">
                <li>联系人：<span><input id="name" name="name" value="{%if linkman is not empty%}{{linkman.name}}{%endif%}"></span></li>
                <li>联系电话：<span><input id="mobile" name="mobile" value="{%if linkman is not empty%}{{linkman.mobile}}{%endif%}"/></span></li>
                <li>联系地址：<span><input id="address" name="address" value="{%if linkAddress is not empty%}{{linkAddress.address}}{%endif%}"/></span></li>

                <li>车牌号：<span><input style="background: #e9e8e7;" disabled="disabled" id="carnum" name="carnum" value="{%if carInfo is not empty%}{{carInfo.number}}{%endif%}" /></span></li>
            </ul>
            <p>车信息：<span><input style="background: #e9e8e7;" disabled="disabled" value="{%if carInfo is not empty%}{{carInfo.getAutoInfo()}}{%endif%}"></span></p>

        </div>
    </div>
    <footer>
        <input type="hidden" name="linkmanId" value="{%if linkman is not empty%}{{linkman.id}}{%endif%}" />
        <input type="hidden" name="linkAddressId" value="{%if linkAddress is not empty%}{{linkAddress.id}}{%endif%}" />
        <input type="hidden" name="carId" value="{%if carInfo is not empty%}{{carInfo.id}}{%endif%}" />
        <input type="submit" value="提交">
    </footer>
    </form>

</div>
</body>
</html>
