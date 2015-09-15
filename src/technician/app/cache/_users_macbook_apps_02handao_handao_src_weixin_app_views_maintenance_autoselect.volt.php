<div class="Hs">
    <h2 class="t"><em><a href="/">&lt;首页</a></em>选择型号</h2>
    <!--品牌-->
    <ul class="m">
        <?php foreach ($a_z as $row) { ?>
        <li class="li" id="<?php echo $row; ?>"><?php echo $row; ?></li>
        <?php foreach ($brands as $brand) { ?>
        <?php if ($brand->initials == $row) { ?>
        <li onclick="DataShow(<?php echo $brand->id; ?>,this)">
            <p class="sp1"><img src="<?php echo $brand->logo_path; ?>"></p>

            <p class="sp2"><?php echo $brand->name; ?></p>
        </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>
    </ul>
    <!--品牌导航-->
    <div class="pk">
        <p class="p">
            <?php foreach ($a_z as $row) { ?><a href="#<?php echo $row; ?>"><?php echo $row; ?></a><?php } ?>
        </p>
    </div>

    <!--系列选择，系列下有型号-->
    <?php foreach ($brands as $brand) { ?>
    <div class="Ms data<?php echo $brand->id; ?>">
        <ul>
            <?php foreach ($autoModel as $model) { ?>
            <?php if ($brand->id == $model->brands_id) { ?>
            <li>
                <p class="p1"><?php echo $model->name; ?></p>
                <ul class="u">
                    <?php foreach ($autoModelExact as $exact) { ?>
                    <?php if ($model->id == $exact->models_id) { ?>
                    <li>
                        <a href="/maintenance/serveselect?brands_id=<?php echo $exact->brands_id; ?>&models_id=<?php echo $exact->models_id; ?>"><?php echo $exact->name; ?></a>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

</div>
<script>
    //显示系列
    var ins = 0;
    function DataShow(classid, objs) {
        if (ins == 0) {
            $('.Hs .m').addClass('om');
        }
        $('.Hs .m li').css('border-left', '0px');
        $(objs).css('border-left', '3px solid #ff4400');
        var obj = '.data' + classid + '';
        $('.Ms').hide();
        $(obj).show();
    }

    //展开关闭型号
    $('.Ms .p1').click(function () {
        if ($(this).next().css('display') == 'block') {
            $(this).next().hide();
            $(this).removeClass('on');
            return false;
        }
        $('.Ms').find('.p1').removeClass('on');
        $(this).addClass('on');

        $('.Ms').find('.u').hide();
        $(this).next().show();
    })
</script>
