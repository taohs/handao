<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/16/15
 * Time: 16:12
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/16/15  Time: 16:12
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
*/
?>
<h2 class="sub-header">重置管理员密码</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputUsername">用户名：</label>
            <div class="col-sm-10">
                <input class="form-control" name="inputUsername" id="inputUsername" value="{{admin.username}}"
                       disabled/>
                <input type="hidden" class="form-control" name="inputId" id="inputId" value="{{admin.id}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputRole">角色：</label>
            <div class="col-sm-10">
                <input  class="form-control" name="inputRole" value="{{admin.HdAdminRole.name}}" disabled/>

            </div>
        </div>
        <div class="form-group" class="checkbox col-sm-2 control-label">
            <label class="col-sm-2 control-label" for="inputIs_valid">启用：</label>
            <div class="col-sm-10 form-horizontal">
                <input type="checkbox" name="inputIs_valid" id="inputIs_valid" {%if admin.is_valid%} checked="checked"
                       {%endif%} disabled/>
            </div>
        </div>
        <div  class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary btn-lg">重置密码</button>
            </div>

        </div>
    </form>
</div>
