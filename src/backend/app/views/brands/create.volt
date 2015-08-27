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
<h2 class="sub-header">新建品牌信息</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputInitials">首字母：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputInitials" >
                    {% for initial in initials %}
                        <option value="{{initial}}">{{initial}}</option>
                    {% endfor %}
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">名称：</label>
            <div class="col-sm-10">
                <input  class="form-control" name="inputName" id="inputName" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputCountry">所属国家：</label>
            <div class="col-sm-10">
                <input class="form-control" name="inputCountry" id="inputCountry" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputLogo">logo：</label>
            <div class="col-sm-10">
                <input type="file" id="inputLogo" name="inputLogo" >
                <p class="help-block">请选择图片文件（jpg,png）</p>
            </div>
        </div>
        <div class="form-group" class="checkbox col-sm-2 control-label">
            <label class="col-sm-2 control-label" for="inputIndustry">行业：</label>
            <div class="col-sm-10 form-horizontal checkbox">
                {% for industry in industries %}
                <label><input type="checkbox" name="inputIndustry[]"  value="{{industry.id}}" />{{industry.name}}&nbsp;&nbsp;</label>
                {% endfor %}
            </div>
        </div>
        <div class="form-group" class="checkbox col-sm-2 control-label">
            <label class="col-sm-2 control-label" for="inputIndustry">品牌类型：</label>
            <div class="col-sm-10 form-horizontal checkbox">
                {% for index,row in brandsComponent.categoryArray %}
                <label><input type="checkbox" name="inputBrandsCategory[]"  value="{{index}}" />{{row}}&nbsp;&nbsp;</label>
                {% endfor %}

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
