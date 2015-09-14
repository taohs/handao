<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/13/15
 * Time: 22:49
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/13/15  Time: 22:49
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
{{content()}}
    <div class="container">

    <form class="form-signin" action="/sign/index" method="post">
        {{flash.output()}}
        <h2 class="form-signin-heading"><img src="{{url('assets/img/logo_big.png')}}"></h2>

        <label for="inputEmail" class="sr-only">登录邮箱</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="登录邮箱" required="" autofocus="">
        <label for="inputPassword" class="sr-only">登录密码</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="登录密码" required="">
        <label for="图形验证码" class="sr-only">验证码</label>
        <input type="password" name="inputCode" id="inputCode" class="form-control" placeholder="验证码" required="" style="width: 120px;">

        <input type="hidden"  name="{{this.security.getTokenKey()}}" value="{{this.security.getToken()}}">
        <img  title="点击刷新" src="/sign/captcha" align="absbottom" onclick="this.src='/sign/captcha?'+Math.random();"/>

        <button class="btn btn-lg btn-primary btn-block" type="submit">登 录</button>
    </form>

</div>
