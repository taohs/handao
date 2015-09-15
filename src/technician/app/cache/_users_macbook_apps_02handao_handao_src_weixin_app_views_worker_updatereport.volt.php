
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $this->url->get('css/member.css'); ?>">
</head>
<body>
<header>
    <a href="/worker/dashboard" class="logo"><img src="<?php echo $this->url->get('images/LOGO-white.png'); ?>" width="100" height="44" alt=""/></a>
    <a href="/worker/logout" class="tuic">退出</a>
    <div class="user">2015-08-12  欢迎您，<span><?php echo $userData->name; ?></span></div>
</header>
<div class="content">
    <?php echo $this->flash->output(); ?>
    <div class="bor-box infor-xq">
        <ul class="clearfix">
            <li>订单编号：<span><?php echo $order->id; ?></span></li>
            <li>预约时间：<span><?php echo $order->book_time; ?></span></li>
            <li>联系人：<span><?php echo $orderLinkman->name; ?></span></li>
            <li>联系电话：<span><?php echo $orderLinkman->mobile; ?></span></li>
            <li>车牌号：<span><?php echo $orderAuto->number; ?></span></li>
            <li>预约项目：<span>机油三滤</span></li>
        </ul>
        <p>备注：<span><?php echo $order->remark; ?>请提前电话联系</span></p>
        <p>联系地址：<span><?php echo $orderAddress->address; ?></span></p>
        <p>车信息：<span><?php echo $orderAuto->getAutoInfo(); ?>奥迪（进口）——A8L——2012.02-2014 - 2.0L</span></p>
    </div>
    <h1>养护项目：</h1>
    <div class="bor-box yfxm">
        <?php foreach ($order->getHdOrderProduct() as $row) { ?>
        <?php $product = $row->getProduct(); ?>
        <?php $category = $row->getProductCategory(); ?>
        <p class="clearfix">
            <span><?php echo $category->name; ?>——<?php echo $product->name; ?></span>
            <label><input type="checkbox" name="products" value="<?php echo $row->id; ?>" <?php if ($row->active == 1) { ?> checked<?php } ?> disabled><span>已更换</span></label>
        </p>

        <?php } ?>

    </div>
    <h1>安全监测</h1>
    <form action="" method="post">
    <div class="aqjc">
        <div class="aqjc-nr">
            <h2><span>外观车灯</span></h2>
            <div class="nr-xq">
                <p>
                    <span>远光灯：</span>
                    <label><input name="far_light" type="radio" value="1"   <?php if ($lightModel->far_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="far_light" type="radio" value="0.8" <?php if ($lightModel->far_light == '0.8') { ?> checked <?php } ?> >昏暗</label>
                    <label><input name="far_light" type="radio" value="0"   <?php if ($lightModel->far_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="far_light" type="radio" value="0.5" <?php if ($lightModel->far_light == '0.5') { ?> checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>近光灯：</span>
                    <label><input name="near_light" type="radio" value="1"  <?php if ($lightModel->near_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="near_light" type="radio" value="0.8"<?php if ($lightModel->near_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="near_light" type="radio" value="0"  <?php if ($lightModel->near_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="near_light" type="radio" value="0.5"<?php if ($lightModel->near_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>转向灯：</span>
                    <label><input name="turn_light" type="radio" value="1"  <?php if ($lightModel->turn_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="turn_light" type="radio" value="0.8"<?php if ($lightModel->turn_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="turn_light" type="radio" value="0"  <?php if ($lightModel->turn_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="turn_light" type="radio" value="0.5"<?php if ($lightModel->turn_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>刹车灯：</span>
                    <label><input name="brake_light" type="radio" value="1"     <?php if ($lightModel->brake_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="brake_light" type="radio" value="0.8"   <?php if ($lightModel->brake_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="brake_light" type="radio" value="0"     <?php if ($lightModel->brake_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="brake_light" type="radio" value="0.5"   <?php if ($lightModel->brake_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>雾灯：</span>
                    <label><input name="fog_light"  type="radio" value="1"      <?php if ($lightModel->fog_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="fog_light"  type="radio" value="0.8"    <?php if ($lightModel->fog_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="fog_light"  type="radio" value="0"      <?php if ($lightModel->fog_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="fog_light"  type="radio" value="0.5"    <?php if ($lightModel->fog_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>小灯：</span>
                    <label><input name="small_light"  type="radio" value="1"    <?php if ($lightModel->small_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="small_light"  type="radio" value="0.8"  <?php if ($lightModel->small_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="small_light"  type="radio" value="0"    <?php if ($lightModel->small_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="small_light"  type="radio" value="0.5"  <?php if ($lightModel->small_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
                <p>
                    <span>倒车灯：</span>
                    <label><input name="reversing_light"  type="radio" value="1"    <?php if ($lightModel->reversing_light == '1') { ?>   checked <?php } ?> >亮</label>
                    <label><input name="reversing_light"  type="radio" value="0.8"  <?php if ($lightModel->reversing_light == '0.8') { ?>   checked <?php } ?> >昏暗</label>
                    <label><input name="reversing_light"  type="radio" value="0"    <?php if ($lightModel->reversing_light == '0') { ?>   checked <?php } ?> >不亮</label>
                    <label><input name="reversing_light"  type="radio" value="0.5"  <?php if ($lightModel->reversing_light == '0.5') { ?>   checked <?php } ?> >只亮一个</label>
                </p>
            </div>
        </div>
        <div class="aqjc-nr">
            <h2><span class="tb1">油液/滤芯/电瓶 </span></h2>
            <div class="nr-xq">
                <p>
                    <span>备胎：</span>
                    <label><input name="spare_tire" maxlength="10" type="radio" value="1"  <?php if ($oilFilterBatteryModel->spare_tire == '1') { ?>   checked <?php } ?> >正常</label>
                    <label><input name="spare_tire" maxlength="10" type="radio" value="0" <?php if ($oilFilterBatteryModel->spare_tire == '0') { ?>   checked <?php } ?> >不正常</label>
                </p>
                <p>
                    <span>机油尺标注：</span>
                    <label><input name="engine_oil_callout" type="radio" value="1"  <?php if ($oilFilterBatteryModel->engine_oil_callout == '1') { ?>   checked <?php } ?> >高位</label>
                    <label><input name="engine_oil_callout" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->engine_oil_callout == '0.5') { ?>   checked <?php } ?> >中位</label>
                    <label><input name="engine_oil_callout" type="radio" value="0" <?php if ($oilFilterBatteryModel->engine_oil_callout == '0') { ?>   checked <?php } ?> >低位</label>
                </p>
                <p>
                    <span>旧机油判断：</span>
                    <label><input name="engine_oil_old_analyzing" type="radio" value="1"  <?php if ($oilFilterBatteryModel->engine_oil_old_analyzing == '1') { ?>   checked <?php } ?> >清澈</label>
                    <label><input name="engine_oil_old_analyzing" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->engine_oil_old_analyzing == '0.5') { ?>   checked <?php } ?> >浑浊</label>
                    <label><input name="engine_oil_old_analyzing" type="radio" value="0"  <?php if ($oilFilterBatteryModel->engine_oil_old_analyzing == '0') { ?>   checked <?php } ?> >严重污浊</label>

                </p>
                <p>
                    <span>空气滤芯：</span>

                    <label><input name="air_filter" type="radio" value="1"  <?php if ($oilFilterBatteryModel->air_filter == '1') { ?>   checked <?php } ?> >清澈</label>
                    <label><input name="air_filter" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->air_filter == '0.5') { ?>   checked <?php } ?> >浑浊</label>
                    <label><input name="air_filter" type="radio" value="0"  <?php if ($oilFilterBatteryModel->air_filter == '0') { ?>   checked <?php } ?> >严重污浊</label>

                </p>
                <p>
                    <span>空调滤芯：</span>
                    <label><input name="air_conditioning_filter" type="radio" value="1"  <?php if ($oilFilterBatteryModel->air_conditioning_filter == '1') { ?>   checked <?php } ?> >干净</label>
                    <label><input name="air_conditioning_filter" type="radio" value="0"  <?php if ($oilFilterBatteryModel->air_conditioning_filter == '0') { ?>   checked <?php } ?> >脏</label>

                </p>
                <p>
                    <span>防冻液冰点：</span>
                    <label><input name="antifreeze_freezing" type="radio" value="1"  <?php if ($oilFilterBatteryModel->antifreeze_freezing == '1') { ?>   checked <?php } ?>  >正常</label>
                    <label><input name="antifreeze_freezing" type="radio" value="0"  <?php if ($oilFilterBatteryModel->antifreeze_freezing == '0') { ?>   checked <?php } ?> >不正常</label>
                </p>
                <p>
                    <span>防冻液目测：</span>
                    <label><input name="antifreeze_visual" type="radio" value="1"  <?php if ($oilFilterBatteryModel->antifreeze_visual == '1') { ?>   checked <?php } ?> >清澈</label>
                    <label><input name="antifreeze_visual" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->antifreeze_visual == '0.5') { ?>   checked <?php } ?> >浑浊</label>

                    <label><input name="antifreeze_visual" type="radio" value="0"  <?php if ($oilFilterBatteryModel->antifreeze_visual == '0') { ?>   checked <?php } ?> >严重污浊</label>

                </p>
                <p>
                    <span>防冻液位:</span>
                    <label><input name="antifreeze_level" type="radio" value="1"  <?php if ($oilFilterBatteryModel->antifreeze_level == '1') { ?>   checked <?php } ?> >高位</label>
                    <label><input name="antifreeze_level" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->antifreeze_level == '0.5') { ?>   checked <?php } ?> >中位</label>
                    <label><input name="antifreeze_level" type="radio" value="0" <?php if ($oilFilterBatteryModel->antifreeze_level == '0') { ?>   checked <?php } ?> >低位</label>
                </p>
                <p>
                    <span>转向助力油目测：</span>
                    <label><input name="steering_oil_visual" type="radio" value="1"  <?php if ($oilFilterBatteryModel->steering_oil_visual == '1') { ?>   checked <?php } ?> >清澈</label>
                    <label><input name="steering_oil_visual" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->steering_oil_visual == '0.5') { ?>   checked <?php } ?> >浑浊</label>

                    <label><input name="steering_oil_visual" type="radio" value="0"  <?php if ($oilFilterBatteryModel->steering_oil_visual == '0') { ?>   checked <?php } ?> >严重污浊</label>

                </p>
                <p>
                    <span>转向助力油位：</span>
                    <label><input name="steering_oil_level" type="radio" value="1"  <?php if ($oilFilterBatteryModel->steering_oil_level == '1') { ?>   checked <?php } ?> >高位</label>
                    <label><input name="steering_oil_level" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->steering_oil_level == '0.5') { ?>   checked <?php } ?> >中位</label>
                    <label><input name="steering_oil_level" type="radio" value="0" <?php if ($oilFilterBatteryModel->steering_oil_level == '0') { ?>   checked <?php } ?> >低位</label>
                </p>
                <p>
                    <span>变速箱油目测：</span>
                    <label><input name="transmission_oil_visual"  type="radio" value="1"  <?php if ($oilFilterBatteryModel->transmission_oil_visual == '1') { ?>   checked <?php } ?> >清澈</label>
                    <label><input name="transmission_oil_visual" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->transmission_oil_visual == '0.5') { ?>   checked <?php } ?> >浑浊</label>

                    <label><input name="transmission_oil_visual" type="radio" value="0"  <?php if ($oilFilterBatteryModel->transmission_oil_visual == '0') { ?>   checked <?php } ?> >严重污浊</label>

                </p>
                <p>
                    <span>变速箱油位：</span>
                    <label><input name="transmission_oil_level" type="radio" value="1"  <?php if ($oilFilterBatteryModel->transmission_oil_level == '1') { ?>   checked <?php } ?> >可检测</label>

                    <label><input name="transmission_oil_level" type="radio" value="0" <?php if ($oilFilterBatteryModel->transmission_oil_level == '0') { ?>   checked <?php } ?>  >无法检测</label>
                </p>
                <p>
                    <span>玻璃水：</span>
                    <label><input name="glass_water" type="radio" value="1"  <?php if ($oilFilterBatteryModel->glass_water == '1') { ?>   checked <?php } ?> >满</label>
                    <label><input name="glass_water" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->glass_water == '0.5') { ?>   checked <?php } ?> >未满</label>
                </p>
                <p>
                    <span>电瓶外观：</span>
                    <label><input name="battery_appearance" type="radio" value="1"  <?php if ($oilFilterBatteryModel->battery_appearance == '1') { ?>   checked <?php } ?> >良好</label>
                    <label><input name="battery_appearance" type="radio" value="0.8" <?php if ($oilFilterBatteryModel->battery_appearance == '0.8') { ?>   checked <?php } ?> >一般</label>
                    <label><input name="battery_appearance" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->battery_appearance == '0.5') { ?>   checked <?php } ?> >差</label>
                </p>
                <p>
                    <span>电瓶充电程度：</span>
                    <label><input name="battery_charge_level" type="radio" value="1"  <?php if ($oilFilterBatteryModel->battery_charge_level == '1') { ?>   checked <?php } ?> >90%以上</label>
                    <label><input name="battery_charge_level"  type="radio" value="0.8" <?php if ($oilFilterBatteryModel->battery_charge_level == '0.8') { ?>   checked <?php } ?> >70%~80%</label>
                    <label><input name="battery_charge_level"  type="radio" value="0.5" <?php if ($oilFilterBatteryModel->battery_charge_level == '0.5') { ?>   checked <?php } ?> >60%~70%</label>
                    <label><input name="battery_charge_level"  type="radio" value="0" <?php if ($oilFilterBatteryModel->battery_charge_level == '0') { ?>   checked <?php } ?> >60%以下</label>
                </p>
                <p>
                    <span>电瓶健康指数：</span>
                    <label><input name="battery_health_index" type="radio" value="1"  <?php if ($oilFilterBatteryModel->battery_health_index == '1') { ?>   checked <?php } ?> >90%以上</label>
                    <label><input name="battery_health_index" type="radio" value="0.8" <?php if ($oilFilterBatteryModel->battery_health_index == '0.8') { ?>   checked <?php } ?> >70%~80%</label>
                    <label><input name="battery_health_index" type="radio" value="0.5" <?php if ($oilFilterBatteryModel->battery_health_index == '0.5') { ?>   checked <?php } ?> >60%~70%</label>
                    <label><input name="battery_health_index" type="radio" value="0" <?php if ($oilFilterBatteryModel->battery_health_index == '0') { ?>   checked <?php } ?> >60%以下</label>
                </p>
                <p>
                    <span>电瓶桩头：</span>
                    <label><input name="battery_pile" type="radio" value="1"  <?php if ($oilFilterBatteryModel->battery_pile == '1') { ?>   checked <?php } ?> >良好</label>
                    <label><input name="battery_pile"  type="radio" value="0.8" <?php if ($oilFilterBatteryModel->battery_pile == '0.8') { ?>   checked <?php } ?> >一般</label>
                    <label><input name="battery_pile"  type="radio" value="0.5" <?php if ($oilFilterBatteryModel->battery_pile == '0.5') { ?>   checked <?php } ?> >差</label>
                </p>
                <p>
                    <span>电瓶指示灯颜色：</span>
                    <label><input name="battery_led_color" type="radio" value="1"  <?php if ($oilFilterBatteryModel->battery_led_color == '1') { ?>   checked <?php } ?> >绿色</label>
                    <label><input name="battery_led_color"  type="radio" value="0" <?php if ($oilFilterBatteryModel->battery_led_color == '0') { ?>   checked <?php } ?> >红色</label>
                </p>
                <p>
                    <span>车内软管和线路：</span>
                    <label><input name="hoses_lines" maxlength="10" type="radio" value="1"  <?php if ($oilFilterBatteryModel->hoses_lines == '1') { ?>   checked <?php } ?> >正常</label>
                    <label><input name="hoses_lines" maxlength="10" type="radio" value="0" <?php if ($oilFilterBatteryModel->hoses_lines == '0') { ?>   checked <?php } ?> >不正常</label>
                </p>
            </div>
        </div>
        <div class="aqjc-nr">
            <h2><span class="tb2">轮胎侧车</span></h2>
            <div class="nr-xq">
                <?php foreach ($tireModel as $row) { ?>
                <h3><?php echo $this->element->getTireNameByPosition($row->position); ?>:<?php echo $row->pressure; ?></h3>
                <p>
                    <span>胎压：</span>
                    <label><input name="pressure[<?php echo $row->position; ?>]" type="radio" value="1"  <?php if ($row->pressure == '1') { ?> checked="checked" <?php } ?>/>正常</label>
                    <label><input name="pressure[<?php echo $row->position; ?>]" type="radio" value="0"  <?php if ($row->pressure == '0') { ?> checked="checked" <?php } ?>/>不正常</label>
                </p>
                <p>
                    <span>出厂日子是否可检查：</span>
                    <label><input name="factory_day_checkable[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->factory_day_checkable == 1) { ?> checked <?php } ?> >可检查</label>
                    <label><input name="factory_day_checkable[<?php echo $row->position; ?>]" type="radio" value="0" <?php if ($row->factory_day_checkable == 0) { ?> checked <?php } ?> >不可检查</label>
                </p>
                <p>
                    <span>出厂日期：</span>
                    <input  name="factory_day[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->factory_day == 1) { ?> checked <?php } ?>/>正常
                    <input  name="factory_day[<?php echo $row->position; ?>]" type="radio" value="0" <?php if ($row->factory_day == 0) { ?> checked <?php } ?>>不正常
                </p>
                <p>
                    <span>花纹深度：</span>
                    <input  name="tread_depth[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->tread_depth == 1) { ?> checked<?php } ?>>正常
                    <input  name="tread_depth[<?php echo $row->position; ?>]" type="radio" value="0"<?php if ($row->tread_depth == 0) { ?> checked<?php } ?>>不正常
                </p>
                <p>
                    <span>老化程度：</span>
                    <label><input name="aging[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->aging == 1) { ?> checked <?php } ?> >轻微</label>
                    <label><input name="aging[<?php echo $row->position; ?>]" type="radio" value="0" <?php if ($row->aging == 0) { ?> checked <?php } ?> >严重</label>

                </p>
                <p>
                    <span>胎面：</span>
                    <input name="tread[<?php echo $row->position; ?>]" maxlength="10" type="radio" value="1" <?php if ($row->tread == 1) { ?> checked<?php } ?>>正常
                    <input name="tread[<?php echo $row->position; ?>]" maxlength="10" type="radio" value="0" <?php if ($row->tread == 0) { ?> checked<?php } ?>>不正常
                </p>
                <p>
                    <span>胎侧：</span>
                    <label><input name="sidewall[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->sidewall == 1) { ?> checked<?php } ?>>正常</label>
                    <label><input name="sidewall[<?php echo $row->position; ?>]" type="radio" value="0"<?php if ($row->sidewall == 0) { ?> checked<?php } ?>>不正常</label>
                </p>
                <p>
                    <span>刹车片是否可检查：</span>
                    <label><input name="brake_pads_checkable[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->brake_pads_checkable == 1) { ?> checked<?php } ?>>可检查</label>
                    <label><input name="brake_pads_checkable[<?php echo $row->position; ?>]" type="radio" value="0"<?php if ($row->brake_pads_checkable == 0) { ?> checked<?php } ?>>不可检查</label>
                </p>
                <p>
                    <span>刹车片厚度：</span>
                    <input name="brake_pads_thickness[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->brake_pads_thickness == 1) { ?> checked<?php } ?>>正常
                    <input name="brake_pads_thickness[<?php echo $row->position; ?>]" type="radio" value="0"<?php if ($row->brake_pads_thickness == 0) { ?> checked<?php } ?>>不正常
                </p>
                <p>
                    <span>刹车盘：</span>
                    <input name="brake_dish[<?php echo $row->position; ?>]" type="radio" value="1" <?php if ($row->brake_dish == 1) { ?> checked<?php } ?>>正常
                    <input name="brake_dish[<?php echo $row->position; ?>]" type="radio" value="0"<?php if ($row->brake_dish == 0) { ?> checked<?php } ?>>不正常
                </p>

                <?php } ?>

            </div>
        </div>
        <div class="aqjc-nr">
            <h2><span class="tb3">其他</span></h2>
            <div class="nr-xq">
                <p>
                    <span>前雨刷：</span>
                    <label><input name="wipers_front" type="radio" value="1"  <?php if ($otherModel->wipers_front == 1) { ?> checked="checked" <?php } ?>>正常</label>
                    <label><input name="wipers_front" type="radio" value="0" <?php if ($otherModel->wipers_front == 0) { ?> checked="checked" <?php } ?>>不正常</label>
                </p>
                <p>
                    <span>后雨刷：</span>
                    <label><input name="wipers_rear" type="radio" value="1"  <?php if ($otherModel->wipers_rear == 1) { ?> checked="checked" <?php } ?>>正常</label>
                    <label><input name="wipers_rear" type="radio" value="0" <?php if ($otherModel->wipers_rear == 0) { ?> checked="checked" <?php } ?>>不正常</label>
                </p>
                <p>
                    <span>灭火器：</span>
                    <label><input name="fire_extinguisher" type="radio" value="1"  <?php if ($otherModel->fire_extinguisher == 1) { ?> checked="checked" <?php } ?>>正常</label>
                    <label><input name="fire_extinguisher"  type="radio" value="0" <?php if ($otherModel->fire_extinguisher == 0) { ?> checked="checked" <?php } ?>>不正常</label>
                </p>
                <p>
                    <span>警示牌：</span>
                    <label><input name="warning_sign" type="radio" value="1"  <?php if ($otherModel->warning_sign == 1) { ?> checked="checked" <?php } ?>>正常</label>
                    <label><input name="warning_sign"  type="radio" value="0" <?php if ($otherModel->warning_sign == 0) { ?> checked="checked" <?php } ?>>不正常</label>
                </p>
            </div>
        </div>
        <div class="aqjc-nr">
            <h2><span class="tb4">保养总结</span></h2>
            <div class="nr-xq">
                <p>
                    <span>轮胎/刹车：</span>
                    <input name="tire_brake" type="text">
                </p>
                <p>
                    <span>外观/灯光：</span>
                    <input name="appearance_lighting" type="text">
                </p>
                <p>
                    <span>油液/滤芯/电瓶：</span>
                    <input name="oil_filter_battery" type="text">
                </p>
                <p>
                    <span>其他：</span>
                    <input name="other" type="text">
                </p>
                <p>
                    <span>总计：</span>
                    <input name="total" type="text">
                </p>
            </div>
        </div>
    </div>
</div>
<footer>
    <input type="submit" value="确认提交">
</footer>
</form>
</body>
</html>