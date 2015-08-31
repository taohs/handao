<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/27/15
 * Time: 16:41
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/27/15  Time: 16:41
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
<div class="form-group">
    <label class="col-sm-2 control-label" for="inputBrands">汽车型号：</label>

    <div class="col-sm-10">
        <select class="form-control" name="inputBrands" id="inputBrands" {% if disabled %} disabled {% endif %}>
            {% for brand in brands %}
            <option value="{{brand.id}}">{{brand.initials ~ '-' ~ brand.name}}</option>
            {% endfor %}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="inputAutoModels"></label>

    <div class="col-sm-10">
        <select class="form-control" name="inputAutoModels" id="inputAutoModels" {% if disabled %} disabled {% endif %}>
            {% for models in autoModels %}
            <option value="{{models.id}}">{{ models.name}}</option>
            {% endfor %}
        </select>
    </div>
</div>
{% if exact %}
<div class="form-group">
    <label class="col-sm-2 control-label" for="inputAutoModelExact"></label>

    <div class="col-sm-10">
        <select class="form-control" name="inputAutoModelExact" id="inputAutoModelExact" {% if disabled %} disabled {% endif %} >
            {% for models in autoModelExacts %}
            <option value="{{models.id}}">{{ models.name}}</option>
            {% endfor %}
        </select>
    </div>
</div>
{% endif %}