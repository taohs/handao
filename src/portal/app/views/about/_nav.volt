<style>
    body {
        background: url('/assets/images/bg2.jpg')
    }

    .content .center .tnav ul li.cid75 a .hv {
        background: #fd642d;
        color: #fff;
        font-size: 14px
    }

    .top .nav ul li.lid665 a {
        background: #fd8c63
    }
</style>

<div class="tnav">
    <h1>{{title}}</h1>
    <ul>
        {% set ActionName=this.dispatcher.getActionName() %}
        <li {% if ActionName=='index' %}class="cid75"{% endif %}><a href="/about">
            <div class="hv">公司简介</div>
        </a></li>
        <li {% if ActionName=='cooperation' %}class="cid75"{% endif %}><a href="/about/cooperation">
            <div class="hv">合作伙伴</div>
        </a></li>
        <li {% if ActionName=='contact' %}class="cid75"{% endif %} style="background: none repeat scroll 0% 0% transparent;"><a
            href="/about/contact">
            <div class="hv">联系我们</div>
        </a></li>
    </ul>
</div>
