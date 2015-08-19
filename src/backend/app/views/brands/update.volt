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
<h2 class="sub-header">修改品牌信息</h2>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputInitials">首字母：</label>
            <div class="col-sm-10">
                <select class="form-control" name="inputInitials">
                    {% for initial in initials %}
                        <option value="{{initial}}" {%if model.initials == initial %}selected {%endif%}>{{initial}}</option>
                    {% endfor %}
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">名称：</label>
            <div class="col-sm-10">
                <input  class="form-control" name="inputName" id="inputName" value="{{model.name}}" />
                <input type="hidden"  class="form-control" name="inputId" id="inputId" value="{{model.id}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputCountry">所属国家：</label>
            <div class="col-sm-10">
                <input class="form-control" name="inputCountry" id="inputCountry" value="{{model.country}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputLogo">logo：</label>
            <div class="col-sm-10">
                <img src="{{model.logo_path}}" style="width: 40px;height: 40px;">

                <input type="file" id="inputLogo" name="inputLogo">
                <p class="help-block">请选择图片文件（jpg,png）</p>
            </div>
        </div>
        <div class="form-group" class="checkbox col-sm-2 control-label">
            <label class="col-sm-2 control-label" for="inputIndustry">行业：</label>
            <div class="col-sm-10 form-horizontal checkbox">
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="1" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]"  value="2"/>汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="3" />汽车 &nbsp;&nbsp;</label> <label><input type="checkbox" name="inputIndustry[]"  />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]"  value="4"/>汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label> <label><input type="checkbox" name="inputIndustry[]"  />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]"  value="0"/>汽车 &nbsp;&nbsp;</label> <label><input type="checkbox" name="inputIndustry[]"  />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]"  value="0"/>汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <label><input type="checkbox" name="inputIndustry[]" value="0" />汽车 &nbsp;&nbsp;</label>
                <input type="checkbox" name="inputIndustry[]"  />电脑&nbsp;&nbsp;
                <input type="checkbox" name="inputIndustry[]"  />汽车&nbsp;&nbsp;
                <input type="checkbox" name="inputIndustry[]"  />汽车&nbsp;&nbsp;
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
