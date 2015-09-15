<div class="top">
    <p>
        <a href="/worker/index" class="logo"><img src="<?php echo $this->url->get('images/logo.png'); ?>" width="98" height="44" alt=""/></a>
        <?php echo date('Y-m-d'); ?>&nbsp;&nbsp;欢迎您，<?php echo $userData->name; ?>
        <a href="/worker/logout">退出</a>
    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="/worker/dashboard" <?php if ($status != $finished) { ?>class="active"<?php } ?>>待养护</a>
            <a href="/worker/dashboard/finished"<?php if ($status == $finished) { ?>class="active"<?php } ?>>已养护</a>
        </p>
    </div>
    <div class="list show">
        <div class="sx">
            <!--<p class="time">
                <a href="index/myorder?day=1" class="today">今天</a>
                <a href="index/myorder?day=2" class="tom">明天</a>
            </p>-->
        </div>
        <div class="biao">
            <table>
                <colgroup>
                    <col width="13%">
                    <col width="7%">
                    <col width="15%">
                    <col width="15%">
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                </colgroup>
                <tbody>
                <tr>
                    <th>订单号</th>
                    <th>预约时间</th>
                    <th>养护项目</th>
                    <th>订单金额</th>
                    <th>联系地址</th>
                    <th>联系人</th>
                    <th>联系电话</th>
                    <th>报告</th>
                </tr>

                <?php foreach ($page->items as $row) { ?>
                <tr>
                    <td><?php echo $row->id; ?></td>

                    <td><?php echo $this->element->getTime($row->book_time); ?></td>
                    <td><?php foreach ($row->getProducts($row->products) as $product) { ?>

                        <?php echo $product; ?><hr>
                        <?php } ?>


                    <td><?php echo $row->total; ?></td>
                    <td><?php echo $row->HdUserAddress->address; ?></td>
                    <td><?php echo $row->HdUserLinkman->name; ?></td>
                    <td><?php echo $row->HdUserLinkman->mobile; ?></td>
                    <?php if ($row->status != $orderSuccessStatus) { ?>
                        <?php if ($status == 'finished') { ?>
                        <td> <a href="/report/detail/<?php echo $row->id; ?>">查看</a> <a href="/worker/updatereport/<?php echo $row->id; ?>">修改</a> </td>
                        <?php } else { ?>
                        <td> <a href="/worker/createreport/<?php echo $row->id; ?>">填写报告</a> </td>
                        <?php } ?>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                </tr>
                <?php } ?>

                </tbody>
            </table>
            <div class="page">
                <?php echo $this->tag->linkTo(array('/worker/dashboard/' . $status . '?page=1', '&lt;&lt;首页')); ?> &nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('/worker/dashboard/' . $status . '?page=' . $page->before, '上一页')); ?>&nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('/worker/dashboard/' . $status . '?page=' . $page->next, '下一页')); ?>&nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('/worker/dashboard/' . $status . '?page=' . $page->last, '末页&gt;&gt;')); ?>
            </div>
        </div>
    </div>


