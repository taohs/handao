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
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required="">
        <input type="hidden"  name="{{this.security.getTokenKey()}}" value="{{this.security.getToken()}}">
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div>
