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
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputParent">所属分类：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputParent" id="inputParent">
                    {% for cate in category %}
                    <option value="{{ cate.id }}" {% if model.category==cate.id %} selected="selected" {% endif %} >{{ cate.name }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMarketPrice">市场价：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputMarketPrice" id="inputMarketPrice" value="{{model.market_price}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMemberPrice">会员价：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputMemberPrice" id="inputMemberPrice" value="{{model.member_price}}"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputDescription">描述：</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="inputDescription" id="inputDescription"/></textarea>
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
