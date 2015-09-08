<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/13/15
 * Time: 22:30
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/13/15  Time: 22:30
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand brand-primary" href="#" style="position: absolute;left: 0px;top: -10px;"><img src="{{url('assets/img/logo_small.png')}}"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a>{{session.auth.username}}</a></li>
                <li><a href="{{url('index/index')}}">我的仪表盘</a></li>
<!--                <li><a href="{{url('system/index')}}">系统设置</a></li>-->
                <li><a href="{{url('admin/password')}}">修改密码</a></li>
            </ul>

        </div>
    </div>
</nav>