
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>车辆体检报告</title>
    <link rel="stylesheet" type="text/css" href="{{url('css/style1.css')}}">
</head>

<body>
<div class="top">
    <p>2015-07-15&nbsp;&nbsp;18:16车辆体检报告</p>
    <span>86</span>
</div>
<div class="light">
    <h3>
        <span></span>
        外观车灯
    </h3>
    <div class="light_list">
        <ul>
            <li>远光灯：<span>{{element.getReportLight(lightModel.far_light)}}</span></li>
            <li>近光灯：<span>{{element.getReportLight(lightModel.near_light)}}</span></li>
            <li>转向灯：<span>{{element.getReportLight(lightModel.turn_light)}}</span></li>
            <li>刹车灯：<span>{{element.getReportLight(lightModel.brake_light)}}</span></li>
            <li>雾&nbsp;&nbsp;&nbsp;灯：<span>{{element.getReportLight(lightModel.fog_light)}}</span></li>
            <li>小&nbsp;&nbsp;&nbsp;灯：<span>{{element.getReportLight(lightModel.small_light)}}</span></li>
            <li>倒车灯：<span>{{element.getReportLight(lightModel.reversing_light)}}</span></li>
        </ul>
    </div>
</div>
<div class="oil">
    <h3>
        <span></span>
        油液/滤芯/电瓶
    </h3>
    <div class="oil_list">
        <ul>
            <li>备胎：<span>{%if oilFilterBatteryModel.spare_tire=="1" %}正常{%else%}不正常 {%endif%} </span></li>
            <li>机油尺标注：
                <span>
                    {%if oilFilterBatteryModel.engine_oil_callout=="1" %}
                    高位
                    {%elseif oilFilterBatteryModel.engine_oil_callout=="0.5"%}
                    中位
                    {%else%}
                    低位
                    {%endif%}
                </span>
            </li>
            <li>旧机油判断：
                <span class="green">
                    {%if oilFilterBatteryModel.engine_oil_callout=="1" %}
                    清澈
                    {%elseif oilFilterBatteryModel.engine_oil_callout=="0.5"%}
                    浑浊
                    {%else%}
                    严重污浊
                    {%endif%}

                </span>
            </li>
            <li>空气滤芯：
                <span>
                    {%if oilFilterBatteryModel.air_filter=="1" %}
                    清澈
                    {%elseif oilFilterBatteryModel.air_filter=="0.5"%}
                    浑浊
                    {%else%}
                    严重污浊
                    {%endif%}
                </span>
            </li>
            <li>空调滤芯：
                <span>{%if oilFilterBatteryModel.air_conditioning_filter=="1" %}
                    干净
                    {%else%}
                    脏
                    {%endif%}
                </span>
            </li>
            <li>防冻液冰点：<span>{%if oilFilterBatteryModel.antifreeze_freezing=="1" %}正常{%else%}不正常{%endif%}</span></li>
            <li>防冻液目测：<span class="green">
                    {%if oilFilterBatteryModel.antifreeze_visual=="1" %}
                    清澈
                    {%elseif oilFilterBatteryModel.antifreeze_visual=="0.5"%}
                    浑浊
                    {%else%}
                    严重污浊
                    {%endif%}</span></li>
            <li>防冻液位：<span>
                    {%if oilFilterBatteryModel.antifreeze_level=="1" %}
                    高位
                    {%elseif oilFilterBatteryModel.antifreeze_level=="0.5"%}
                    中位
                    {%else%}
                    低位
                    {%endif%}</span></li>
            <li>转向助力油目测：<span class="green"> {%if oilFilterBatteryModel.steering_oil_visual=="1" %}
                    清澈
                    {%elseif oilFilterBatteryModel.steering_oil_visual=="0.5"%}
                    浑浊
                    {%else%}
                    严重污浊
                    {%endif%}</span></li>
            <li>转向助力油位：<span>{%if oilFilterBatteryModel.steering_oil_level=="1" %}
                    高位
                    {%elseif oilFilterBatteryModel.steering_oil_level=="0.5"%}
                    中位
                    {%else%}
                    低位
                    {%endif%}</span></li>
            <li>变速箱油目测：<span class="green">
                    {%if oilFilterBatteryModel.transmission_oil_visual=="1" %}
                    清澈
                    {%elseif oilFilterBatteryModel.transmission_oil_visual=="0.5"%}
                    浑浊
                    {%else%}
                    严重污浊
                    {%endif%}</span></li>
            <li>变速箱油位：<span>{%if oilFilterBatteryModel.transmission_oil_level=="1" %}可检测{%else%}无法检测{%endif%}</span></li>
            <li>玻璃水：<span class="green">{%if oilFilterBatteryModel.glass_water=="1" %}满{%else%}未满{%endif%}</span></li>
            <li>电瓶外观：<span class="green">
                    {%if oilFilterBatteryModel.battery_appearance=="1" %}
                    良好
                    {%elseif oilFilterBatteryModel.battery_appearance=="0.5"%}
                    一般
                    {%else%}
                    差
                    {%endif%}
                </span>
            </li>
            <li>电瓶充电程度：<span>
                    {%if oilFilterBatteryModel.battery_appearance=="1" %}
                    90%以上
                    {%elseif oilFilterBatteryModel.battery_appearance=="0.8"%}
                    70%~80%
                    {%elseif oilFilterBatteryModel.battery_appearance=="0.5"%}
                    60%~70%
                    {%else%}
                    60%以下
                    {%endif%}
                    </span></li>
            <li>电瓶健康指数：<span>{%if oilFilterBatteryModel.battery_health_index=="1" %}
                    90%以上
                    {%elseif oilFilterBatteryModel.battery_health_index=="0.8"%}
                    70%~80%
                    {%elseif oilFilterBatteryModel.battery_health_index=="0.5"%}
                    60%~70%
                    {%else%}
                    60%以下
                    {%endif%}</span></li>
            <li>电瓶桩头：<span class="green"> {%if oilFilterBatteryModel.battery_pile=="1" %}
                    良好
                    {%elseif oilFilterBatteryModel.battery_pile=="0.8"%}
                    一般
                    {%else%}
                    差
                    {%endif%}</span></li>
            <li>电瓶指示灯颜色：<span class="green">{%if oilFilterBatteryModel.battery_led_color=="1" %}绿色{%else%}红色{%endif%}</span></li>
            <li>车内软管和线路：<span>{%if oilFilterBatteryModel.hoses_lines=="1" %}正常{%else%}不正常{%endif%}</span></li>
        </ul>
    </div>
</div>
<div class="lunt">
    <h3>
        <span></span>
        轮胎侧车
    </h3>
    <div class="lunt_list">
        {% for row in tireModel %}
        <p>{{element.getTireNameByPosition(row.position)}}</p>
        <ul>
        <li>胎压：<span>{% if row.pressure=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>出厂日子是否可检查：<span>{% if row.factory_day_checkable=="1" %}可检查{%else%}不可检查{% endif %}</span></li>
        <li>出厂日期：<span>{% if row.factory_day=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>花纹深度：<span>{% if row.tread_depth=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>老化程度：<span>{% if row.aging=="1" %}轻微{%else%}严重{% endif %}</span></li>
        <li>胎面<span>{% if row.tread=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>胎侧：<span>{% if row.sidewall=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>刹车片是否可检查：<span>{% if row.brake_pads_checkable=="1" %}可检查{%else%}不可检查{% endif %}</span></li>
        <li>刹车片厚度：<span>{% if row.brake_pads_thickness=="1" %}正常{%else%}不正常{% endif %}</span></li>
        <li>刹车盘：<span>{% if row.brake_dish=="1" %}正常{%else%}不正常{% endif %}</span></li>
        </ul>
        {% endfor %}

    </div>
</div>
<div class="other">
    <h3>
        <span></span>
        其他
    </h3>
    <div class="other_list">
        <ul>
            <li>前雨刷：<span>{% if otherModel.wipers_front==1 %}正常{%else%}不正常{% endif %}</span></li>
            <li>后雨刷：<span>{% if otherModel.wipers_rear==1 %}正常{%else%}不正常{% endif %}</span></li>
            <li>灭火器：<span>{% if otherModel.fire_extinguisher==1 %}正常{%else%}不正常{% endif %}</span></li>
            <li>警示牌：<span>{% if otherModel.warning_sign==1 %}正常{%else%}不正常{% endif %}</span></li>
        </ul>
    </div>
</div>
<div class="zongj">
    <h3>
        <span></span>
        保养总结
    </h3>
    <div class="zongj_list">
        <ul>
            <li>轮胎/刹车：<span>{{summaryModel.tire_brake}}</span></li>
            <li>外观/灯光：<span>{{summaryModel.appearance_lighting}}</span></li>
            <li>油液/滤芯/电瓶：<span>{{summaryModel.oil_filter_battery}}</span></li>
            <li>其他：<span>{{summaryModel.other}}</span></li>
            <li>总计：<span>{{summaryModel.total}}</span></li>
        </ul>
    </div>
</div>






</body>
</html>
