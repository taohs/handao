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
    <li class="active"><a href="{{url('index/index')}}">我的仪表盘 <span class="sr-only">(current)</span></a></li>
    <li><a href="{{url('admin/index')}}">后台人员管理</a></li>
    <li><a href="{{url('index/index')}}">技师管理</a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
        </ul>
    </li>
</ul>
<ul class="nav nav-sidebar">
    <li><a href="{{url('member')}}">平台会员</a></li>
    <li><a href="{{url('order')}}">订单管理</a></li>
    <li><a href="{{url('auto')}}">会员车辆</a></li>
    <li><a href="{{url('index/index')}}">Another nav item</a></li>
    <li><a href="{{url('index/index')}}">More navigation</a></li>
</ul>
<ul class="nav nav-sidebar">
    <li><a href="{{url('products')}}">商品管理</a></li>
    <li><a href="{{url('brands')}}">品牌管理</a></li>
    <li><a href="{{url('industy/index')}}">行业</a></li>
</ul>
