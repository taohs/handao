<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/16/15
 * Time: 11:38
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/16/15  Time: 11:38
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
<h2 class="sub-header">新建产品分类</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputUsername">名称：</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="inputUsername" id="inputUsername"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputParentId">所属分类：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputParentId" id="inputParentId">
                    {% for cate in category %}
                    <option value="{{ cate.id }}" {% if(model.category == cata.id) %} selected="selected" {% endif %}>{{ cate.name }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>

        <div  class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">提交保存</button>
            </div>

        </div>
    </form>
</div>
