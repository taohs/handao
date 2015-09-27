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

<h2 class="sub-header">配件类型</h2>
<div class="table-responsive">
    <a href="create" class="btn btn-primary">新增类型</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>名称</th>
            <th>父级</th>

            <th>所属行业</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% if paginate.items is not empty %}
        {% for model in paginate.items %}
        <tr>
            <td>{{model.id}}</td>
            <td>{{model.name}}</td>
            <td>
                {% set parent=model.getParentModel()%}
                {%if parent%}
                {{parent.name}}
                {%endif%}
            </td>
            <td>{% if model.HDIndustry %}{{model.HDIndustry.name}}{% endif %}</td>
            <td>{% if model.active %}启用{%else%}禁用{% endif %}</td>
            <td>{{link_to( dispatcher.getControllerName()~"/update/" ~ model.id,'编辑',true,'class':'abc')}}</td>
        </tr>
        {% endfor %}
        {% endif %}
        </tbody>

    </table>
</div>
{{element.getPaginateLink(paginate)}}

