
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>车辆体检报告</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->url->get('css/style1.css'); ?>">
</head>

<body>
<div class="top">
    <p> <?php echo $orderAuto->number; ?> &nbsp; &nbsp;<?php echo $orderAuto->getAutoInfo(); ?><br/> <?php echo $model->create_time; ?> &nbsp; &nbsp;车辆体检报告</p>
    <span><?php echo $summaryModel->total; ?></span>
</div>
<div class="light">
    <h3>
        <span></span>
        外观车灯
    </h3>
    <div class="light_list">
        <ul>
            <li>远光灯：<span><?php echo $this->element->getReportLight($lightModel->far_light); ?></span></li>
            <li>近光灯：<span><?php echo $this->element->getReportLight($lightModel->near_light); ?></span></li>
            <li>转向灯：<span><?php echo $this->element->getReportLight($lightModel->turn_light); ?></span></li>
            <li>刹车灯：<span><?php echo $this->element->getReportLight($lightModel->brake_light); ?></span></li>
            <li>雾&nbsp;&nbsp;&nbsp;灯：<span><?php echo $this->element->getReportLight($lightModel->fog_light); ?></span></li>
            <li>小&nbsp;&nbsp;&nbsp;灯：<span><?php echo $this->element->getReportLight($lightModel->small_light); ?></span></li>
            <li>倒车灯：<span><?php echo $this->element->getReportLight($lightModel->reversing_light); ?></span></li>
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
            <li>备胎：<span><?php if ($oilFilterBatteryModel->spare_tire == '1') { ?>正常<?php } else { ?>不正常 <?php } ?> </span></li>
            <li>机油尺标注：
                <span>
                    <?php if ($oilFilterBatteryModel->engine_oil_callout == '1') { ?>
                    高位
                    <?php } elseif ($oilFilterBatteryModel->engine_oil_callout == '0.5') { ?>
                    中位
                    <?php } else { ?>
                    低位
                    <?php } ?>
                </span>
            </li>
            <li>旧机油判断：
                <span class="green">
                    <?php if ($oilFilterBatteryModel->engine_oil_callout == '1') { ?>
                    清澈
                    <?php } elseif ($oilFilterBatteryModel->engine_oil_callout == '0.5') { ?>
                    浑浊
                    <?php } else { ?>
                    严重污浊
                    <?php } ?>

                </span>
            </li>
            <li>空气滤芯：
                <span>
                    <?php if ($oilFilterBatteryModel->air_filter == '1') { ?>
                    清澈
                    <?php } elseif ($oilFilterBatteryModel->air_filter == '0.5') { ?>
                    浑浊
                    <?php } else { ?>
                    严重污浊
                    <?php } ?>
                </span>
            </li>
            <li>空调滤芯：
                <span><?php if ($oilFilterBatteryModel->air_conditioning_filter == '1') { ?>
                    干净
                    <?php } else { ?>
                    脏
                    <?php } ?>
                </span>
            </li>
            <li>防冻液冰点：<span><?php if ($oilFilterBatteryModel->antifreeze_freezing == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
            <li>防冻液目测：<span class="green">
                    <?php if ($oilFilterBatteryModel->antifreeze_visual == '1') { ?>
                    清澈
                    <?php } elseif ($oilFilterBatteryModel->antifreeze_visual == '0.5') { ?>
                    浑浊
                    <?php } else { ?>
                    严重污浊
                    <?php } ?></span></li>
            <li>防冻液位：<span>
                    <?php if ($oilFilterBatteryModel->antifreeze_level == '1') { ?>
                    高位
                    <?php } elseif ($oilFilterBatteryModel->antifreeze_level == '0.5') { ?>
                    中位
                    <?php } else { ?>
                    低位
                    <?php } ?></span></li>
            <li>转向助力油目测：<span class="green"> <?php if ($oilFilterBatteryModel->steering_oil_visual == '1') { ?>
                    清澈
                    <?php } elseif ($oilFilterBatteryModel->steering_oil_visual == '0.5') { ?>
                    浑浊
                    <?php } else { ?>
                    严重污浊
                    <?php } ?></span></li>
            <li>转向助力油位：<span><?php if ($oilFilterBatteryModel->steering_oil_level == '1') { ?>
                    高位
                    <?php } elseif ($oilFilterBatteryModel->steering_oil_level == '0.5') { ?>
                    中位
                    <?php } else { ?>
                    低位
                    <?php } ?></span></li>
            <li>变速箱油目测：<span class="green">
                    <?php if ($oilFilterBatteryModel->transmission_oil_visual == '1') { ?>
                    清澈
                    <?php } elseif ($oilFilterBatteryModel->transmission_oil_visual == '0.5') { ?>
                    浑浊
                    <?php } else { ?>
                    严重污浊
                    <?php } ?></span></li>
            <li>变速箱油位：<span><?php if ($oilFilterBatteryModel->transmission_oil_level == '1') { ?>可检测<?php } else { ?>无法检测<?php } ?></span></li>
            <li>玻璃水：<span class="green"><?php if ($oilFilterBatteryModel->glass_water == '1') { ?>满<?php } else { ?>未满<?php } ?></span></li>
            <li>电瓶外观：<span class="green">
                    <?php if ($oilFilterBatteryModel->battery_appearance == '1') { ?>
                    良好
                    <?php } elseif ($oilFilterBatteryModel->battery_appearance == '0.5') { ?>
                    一般
                    <?php } else { ?>
                    差
                    <?php } ?>
                </span>
            </li>
            <li>电瓶充电程度：<span>
                    <?php if ($oilFilterBatteryModel->battery_appearance == '1') { ?>
                    90%以上
                    <?php } elseif ($oilFilterBatteryModel->battery_appearance == '0.8') { ?>
                    70%~80%
                    <?php } elseif ($oilFilterBatteryModel->battery_appearance == '0.5') { ?>
                    60%~70%
                    <?php } else { ?>
                    60%以下
                    <?php } ?>
                    </span></li>
            <li>电瓶健康指数：<span><?php if ($oilFilterBatteryModel->battery_health_index == '1') { ?>
                    90%以上
                    <?php } elseif ($oilFilterBatteryModel->battery_health_index == '0.8') { ?>
                    70%~80%
                    <?php } elseif ($oilFilterBatteryModel->battery_health_index == '0.5') { ?>
                    60%~70%
                    <?php } else { ?>
                    60%以下
                    <?php } ?></span></li>
            <li>电瓶桩头：<span class="green"> <?php if ($oilFilterBatteryModel->battery_pile == '1') { ?>
                    良好
                    <?php } elseif ($oilFilterBatteryModel->battery_pile == '0.8') { ?>
                    一般
                    <?php } else { ?>
                    差
                    <?php } ?></span></li>
            <li>电瓶指示灯颜色：<span class="green"><?php if ($oilFilterBatteryModel->battery_led_color == '1') { ?>绿色<?php } else { ?>红色<?php } ?></span></li>
            <li>车内软管和线路：<span><?php if ($oilFilterBatteryModel->hoses_lines == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        </ul>
    </div>
</div>
<div class="lunt">
    <h3>
        <span></span>
        轮胎侧车
    </h3>
    <div class="lunt_list">
        <?php foreach ($tireModel as $row) { ?>
        <p><?php echo $this->element->getTireNameByPosition($row->position); ?></p>
        <ul>
        <li>胎压：<span><?php if ($row->pressure == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>出厂日子是否可检查：<span><?php if ($row->factory_day_checkable == '1') { ?>可检查<?php } else { ?>不可检查<?php } ?></span></li>
        <li>出厂日期：<span><?php if ($row->factory_day == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>花纹深度：<span><?php if ($row->tread_depth == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>老化程度：<span><?php if ($row->aging == '1') { ?>轻微<?php } else { ?>严重<?php } ?></span></li>
        <li>胎面<span><?php if ($row->tread == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>胎侧：<span><?php if ($row->sidewall == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>刹车片是否可检查：<span><?php if ($row->brake_pads_checkable == '1') { ?>可检查<?php } else { ?>不可检查<?php } ?></span></li>
        <li>刹车片厚度：<span><?php if ($row->brake_pads_thickness == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        <li>刹车盘：<span><?php if ($row->brake_dish == '1') { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
        </ul>
        <?php } ?>

    </div>
</div>
<div class="other">
    <h3>
        <span></span>
        其他
    </h3>
    <div class="other_list">
        <ul>
            <li>前雨刷：<span><?php if ($otherModel->wipers_front == 1) { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
            <li>后雨刷：<span><?php if ($otherModel->wipers_rear == 1) { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
            <li>灭火器：<span><?php if ($otherModel->fire_extinguisher == 1) { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
            <li>警示牌：<span><?php if ($otherModel->warning_sign == 1) { ?>正常<?php } else { ?>不正常<?php } ?></span></li>
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
            <li>轮胎/刹车：<span><?php echo $summaryModel->tire_brake; ?></span></li>
            <li>外观/灯光：<span><?php echo $summaryModel->appearance_lighting; ?></span></li>
            <li>油液/滤芯/电瓶：<span><?php echo $summaryModel->oil_filter_battery; ?></span></li>
            <li>其他：<span><?php echo $summaryModel->other; ?></span></li>
            <li>总计：<span><?php echo $summaryModel->total; ?></span></li>
        </ul>
    </div>
</div>






</body>
</html>
