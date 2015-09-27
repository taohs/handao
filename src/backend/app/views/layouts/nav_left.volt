<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 01:04
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 01:04
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */?>
<ul class="nav nav-sidebar">



    <li controllername="index" ><a href="{{url('index/index')}}">养护统计 <span class="sr-only">(current)</span></a></li>

    <li controllername="technician"><a href="{{url('technician')}}">技师管理</a></li>


    {%if auth.role == 1%}
    <li controllername="admin"><a href="{{url('admin/index')}}">账号管理</a></li>
<!--    <li controllername="industry"><a href="{{url('industry/index')}}">行业管理</a></li>-->

    {%endif%}


</ul>
<ul class="nav nav-sidebar">



    <li controllername="brands"><a href="{{url('brands')}}">汽车品牌</a></li>
    <li controllername="models"><a href="{{url('models')}}">汽车系列</a></li>
    <li controllername="cars"><a href="{{url('cars')}}">汽车型号</a></li>

    <li controllername="products"><a href="{{url('products')}}">汽车配件</a></li>
    <li controllername="productscategory"><a href="{{url('productscategory')}}">汽车配件类型</a></li>



</ul>

<ul class="nav nav-sidebar">

    <li controllername="member"><a href="{{url('member')}}">会员信息</a></li>
    <li controllername="order"><a href="{{url('order')}}">会员订单</a></li>
</ul>
<script>
    var controllerName = '{{controllerName}}';

    $('.nav li').each(function (k,v) {
//        alert(controllerName);
//        alert($(v).attr('controllername'));
        if($(v).attr('controllername')==controllerName){
            $(v).addClass('active');
        }
    })

</script>