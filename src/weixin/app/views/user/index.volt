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
    <div class="list show">
        <div class="info-wapper control-view">
            <h1>个人信息
                <a href="/user/edit" class="toEdit">修改信息</a>
            </h1>
            <ul class="clearfix">
                <li>联系人：<span>{%if linkman is not empty%}{{linkman.name}}{%endif%}</span></li>
                <li>联系电话：<span>{%if linkman is not empty%}{{linkman.mobile}}{%endif%}</span></li>
                <li>车牌号：<span>{%if carInfo is not empty%}{{carInfo.number}}{%endif%}</span></li>
            </ul>
            <p>联系地址：<span>{%if linkAddress is not empty%}{{linkAddress.address}}{%endif%}</span></p>

            <p>车信息：<span>{%if carInfo is not empty%}
                    {{carInfo.getAutoInfo()}}

                    {%endif%}</span></p>
        </div>


    </div>
    <footer>
        <input type="submit" value="我要保养">
    </footer>


</body>
</html>
