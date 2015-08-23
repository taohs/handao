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
            <label class="col-sm-2 control-label" for="inputName">名称：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputName" id="inputName" value="{{model.name}}"/>
                <input type="hidden" class="form-control" name="inputId" id="inputId" value="{{model.id}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputParent">所属分类：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputParent" id="inputParent">
                    {% for cate in category %}
                    <option value="{{ cate.id }}" {% if  model.parent_id ==cate.id %} selected="selected" {%endif%} >{{ cate.name }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputDescription">描述：</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="inputDescription" id="inputDescription" />{{model.description}}</textarea>
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
