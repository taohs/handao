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
<h2 class="sub-header">车系信息 - 修改车系 </h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputBrands">所属品牌：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputBrands" id="inputBrands">
                    {% for brand in brands %}
                        <option value="{{brand.id}}" {% if brand.id == model.brands_id %} selected {% endif %} >{{brand.initials ~ '-' ~ brand.name}}</option>
                    {% endfor %}
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoModels">所属车型：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputAutoModels"  id="inputAutoModels">
                    {% for models in autoModels %}
                    <option value="{{models.id}}" {% if brand.id == model.brands_id %} selected {% endif %}>{{ models.name}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">名称：</label>
            <div class="col-sm-10">
                <input  class="form-control" name="inputName" id="inputName" value="{{model.name}}" />
                <input type="hidden" class="form-control" name="inputId" id="inputId" value="{{model.id}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputYears">年份：</label>
            <div class="col-sm-10">
                <input class="form-control" name="inputYears" id="inputYears" value="{{model.year}}" />
                <p class="help-block">输入改车系版本各年用英文标点逗号分割 如：2003<strong style="color: red">,</strong>2004</p>
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
<script type="text/javascript">
    $('#inputBrands').change(function () {
        $.getJSON('/models/getModelsByBrandsID/'+$(this).val(),function(data){
            $('#inputAutoModels').html('');
            $.each(data,function (v,n) {
                var option = '<option value="' + v +'">'+ n + '</option>';
                $('#inputAutoModels').append(option);
            });
        });
    })
</script>