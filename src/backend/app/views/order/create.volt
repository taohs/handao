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
<h2 class="sub-header">新建产品</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">预约人：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputName" id="inputName" value="{{model.name}}"/>
                <input type="text" class="form-control" name="step" id="step" value="2"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputTime">预约时间：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputTime" id="inputTime" value="{{model.time}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAddress">预约地点：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAddress" id="inputAddress" value="{{model.address}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoMumber">车牌号码：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAutoMumber" id="inputAutoMumber" value="{{model.autoMumber}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputCategory">汽车型号：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputCategory" id="inputCategory">
                    {% for cate in category %}
                    <option value="{{ cate.id }}" {% if model.category==cate.id %} selected="selected" {% endif %} >{{ cate.name }}</option>
                    {% endfor %}
                </select>
                <select class="form-control" name="inputCategory" id="inputCategory">
                    {% for cate in category %}
                    <option value="{{ cate.id }}" {% if model.category==cate.id %} selected="selected" {% endif %} >{{ cate.name }}</option>
                    {% endfor %}
                </select>
                <select class="form-control" name="inputCategory" id="inputCategory">
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
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAttributes">属性：</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="inputAttributes" id="inputAttributes" rows="6"/></textarea>
                <p class="help-block">每一行设置一个属性；以中文冒号'：'分隔属性名称和值（例如：长：100mm）</p>
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
