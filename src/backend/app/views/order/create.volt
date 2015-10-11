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
<h2 class="sub-header">新建订单</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">预约人：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputName" id="inputName" value=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMobile">电话号码：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputMobile" id="inputMobile" value=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAddress">预约地点：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAddress" id="inputAddress" value=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputBookTime">预约时间：</label>
            <div class="col-sm-10" style="padding-left: 0; ">
<!--                <input type="datetime-local" class="form-control" name="inputBookTime" id="inputBookTime" value=""/>-->
                <div class=" col-sm-6 input-append date  "  data-date="{{date('Y-m-d H:i:s')}}" data-date-format="yyyy-mm-dd hh:ii:ss">
                    <input name="inputBookTime" class="span2 form-control" size="16" type="date" value="{{date('Y-m-d H:i:s')}}">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>

                <div class="col-sm-6 ">
                    <select class="form-control" name="bookTime">
                        <option value="08:00-12:00 上午">08:00 - 12:00 上午</option>
                        <option value="12:00-14:00 中午">12:00 - 14:00 中午</option>
                        <option value="14:00-18:00 下午">14:00 - 18:00 下午</option>
<!--                        <option value="18:00-24:00 晚上">18:00 - 24:00 晚上</option>-->
<!--                        <option value="00:00-08:00 凌晨">00:00 - 08:00 凌晨</option>-->
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoNumber">车牌号码：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputAutoNumber" id="inputAutoNumber" value=""/>
            </div>
        </div>

        {{partial('common/auto_tpl',['exact':true])}}

        {%for category in productsCategory %}
        <div class="form-group productsCategory">
            <label class="col-sm-2 control-label" for="inputProducts">{{category.name}}</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputProducts[]">
                    <option>请选择</option>
                    {% for models in category.getHdProduct("member_price > '0'") %}
                    <option value="{{models.id}}">{{ models.name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="aligin:right;">￥{{models.market_price}}</strong></option>
                    {% endfor %}
                </select>
            </div>
        </div>
        {% endfor %}
        <div class="form-group" id="form-remark">
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
<link rel="stylesheet" href="/assets/js/datetimepicker/css/bootstrap-datetimepicker.css">
{{javascript_include('assets/js/datetimepicker/js/bootstrap-datetimepicker.min.js')}}
{{javascript_include('assets/js/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}


<script>
    $('#datetimepicker').datetimepicker();
</script>