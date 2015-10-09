{{partial('user/_head')}}
<style>
    input{
        height: 32px;
        width: 99%;
        border: 1px solid #ccc;
        font-size: 14px;
        text-indent: 10px;
    }
    select{
        height: 32px;
        width: 25%;
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

                <li>车牌号：<span><input  id="carnum" name="carnum" value="{%if carInfo is not empty%}{{carInfo.number}}{%endif%}" /></span></li>
            </ul>
            <p>车信息：
                <span>
                    <select>
                        <option value="0">请选择</option>
                        {%for row in brands %}
                        <option value="{{row.id}}" {%if row.id == modelExact.brands_id%} selected="selected" {%endif%}  >{{row.initials}} - {{row.name}}</option>
                        {%endfor%}
                    </select>
                </span>
            <span>
                    <select>
                        <option value="0">请选择</option>
                        {%for row in autoModels %}
                        <option value="{{row.id}}" {%if row.id == modelExact.models_id%} selected="selected" {%endif%}  >{{row.name}}</option>
                        {%endfor%}
                    </select>
                </span>
            <span>
                    <select>
                        <option value="0">请选择</option>
                        {%for row in autoModelsExacts %}
                        <option value="{{row.id}}" {%if row.id == modelExact.brands_id%} selected="selected" {%endif%}  >{{row.name}}</option>
                        {%endfor%}
                    </select>
                </span>

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
