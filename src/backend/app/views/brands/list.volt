<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 14:22
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 14:22
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */?>

<h2 class="sub-header">品牌列表</h2>
<div class="table-responsive">
    <a href="/brands/create" class="btn btn-primary">新增品牌</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>首字母</th>
            <th>名称</th>
            <th>行业</th>
            <th>类型</th>
            <th>国家</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for model in paginate.items %}
        <tr>
            <td>{{model.initials}}</td>
            <td>{{model.name}} &nbsp;<img src="{{model.logo_path}}" width="40px" height="20px"></td>
            <td>{%if model.getIndustry()%}
                {%  for bi in model.getIndustry() %}
                {{      bi.name }}&nbsp;&nbsp;
                {%  endfor %}
                {#{model.HdBrandsIndustry.id}#}
                {%endif%}
            </td>
            <td>{%if model.getBrandCategoryName()%}
                {%  for categoryName in model.getBrandCategoryName() %}
                {{      categoryName }}&nbsp;&nbsp;
                {%  endfor %}
                {#{model.HdBrandsIndustry.id}#}
                {%endif%}
            </td>
            <td>{{model.country}}</td>
            <td>{{link_to("brands/update/" ~ model.id,'编辑',true,'class':'abc')}} </td>
        </tr>
        {% endfor %}
        </tbody>

    </table>
</div>

{{element.getPaginateLink(paginate)}}

