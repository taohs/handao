<div class="top">
    <p>

        <a href="/index/index" class="logo"><img src="<?php echo $this->url->get('images/logo.png'); ?>" width="98" height="44" alt=""/></a>
        <?php echo date('Y-m-d'); ?>&nbsp;&nbsp;欢迎您，<?php echo $userData->mobile; ?>
        <a href="/index/logout">退出</a>

    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="/index/myorder" >待养护</a>
            <a href="#" class="active">已养护</a>
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
                    <col width="25%">
                    <col width="25%">
                    <col width="40%">
                    <col width="10%">
                </colgroup>
                <tbody>
                <tr>
                    <th>养护完成时间</th>
                    <th>订单号</th>
                    <th>养护项目</th>
                    <th>查看</th>
                </tr>
                <?php foreach ($page->items as $row) { ?>
                <tr>
                    <td><?php echo $row->service_time; ?></td>
                    <td><?php echo $row->id; ?></td>

                    <td> <?php $products = $row->getProducts($row->products); ?>
                        <?php if ($products) { ?>
                        <?php foreach ($products as $index => $product) { ?>
                        <?php echo $product; ?><?php if ($index + 1 < $this->length($products)) { ?><hr><?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </td>
                    <td><a href="/report/detail/<?php echo $row->id; ?>"></a></td>

                </tr>
                <?php } ?>

                </tbody>
            </table>



                </tbody>
            </table>
            <div class="page">
                <?php echo $this->tag->linkTo(array('index/myorder?page=1', '&lt;&lt;首页')); ?> &nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('index/myorder?page=' . $page->before, '上一页')); ?>&nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('index/myorder?page=' . $page->next, '下一页')); ?>&nbsp;&nbsp;
                <?php echo $this->tag->linkTo(array('index/myorder?page=' . $page->last, '末页&gt;&gt;')); ?>
            </div>
        </div>
    </div>


