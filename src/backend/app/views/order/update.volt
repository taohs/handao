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
{{content()}}
<h2 class="sub-header">新建订单</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">预约人：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputName" id="inputName" value="{{modelLinkman.name}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMobile">电话号码：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputMobile" id="inputMobile" value="{{modelLinkman.mobile}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAddress">预约地点：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAddress" id="inputAddress" value="{{model.address_info}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputBookTime">预约时间：</label>
            <div class="col-sm-10">
                <input type="datetime" class="form-control" name="inputBookTime" id="inputBookTime" value="{{model.book_time}}"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoNumber">车牌号码：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAutoNumber" id="inputAutoNumber" value="{{modelAuto.number}}"/>
            </div>
        </div>

        {{partial('common/auto_tpl',['exact':true])}}

        {%for category in productsCategory %}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputProducts">{{category.name}}</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputProducts[]">
                    <option>请选择</option>
                    {% for models in category.getHdProduct() %}
                    <option value="{{models.id}}" {%if models.id in modelProductsIdArray %} selected="selected" {% endif %}>{{ models.name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="aligin:right;">￥{{models.market_price}}</strong></option>
                    {% endfor %}
                </select>
            </div>
        </div>
        {% endfor %}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputRemark">备注：</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="inputRemark" id="inputRemark" rows="6"/></textarea>

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
{{partial('common/auto_js')}}

