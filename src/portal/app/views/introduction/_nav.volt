<style>
    body{background:url(/assets//images/bg2.jpg)}
    .content .center .tnav ul li.cid64  a .hv{background: #FD642D;color: #fff;font-size: 14px}
    .top .nav ul li.lid654 a{background: #fd8c63}
</style>

<div class="tnav">
    <h1>服务流程</h1>
    <ul>
        {% set ActionName=this.dispatcher.getActionName() %}
        <ul>
            <li {% if ActionName == 'index' %}class="cid64"{% endif %} ><a href="/introduction"><div class="hv">服务流程</div></a></li>
            <li {% if ActionName == 'oilfilter' %}class="cid64"{% endif %}><a href="/introduction/oilfilter"><div class="hv">机油三滤</div></a></li>
            <li {% if ActionName == 'filter' %}class="cid64"{% endif %}><a href="/introduction/filter"><div class="hv">机油机滤</div></a></li>
            <li {% if ActionName == 'airconditioner' %}class="cid64"{% endif %}><a href="/introduction/airconditioner"><div class="hv">空调过滤清洗</div></a></li>
            <li {% if ActionName == 'engine' %}class="cid64"{% endif %}><a href="/introduction/engine"><div class="hv">发动机舱清洗</div></a></li>
            <li {% if ActionName == 'tires' %}class="cid64"{% endif %} style="background: none repeat scroll 0% 0% transparent;"><a href="/introduction/tires"><div class="hv">换胎服务</div></a></li>
        </ul>
    </ul>
</div>
