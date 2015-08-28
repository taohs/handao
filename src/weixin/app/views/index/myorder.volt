<div class="top">
    <p>
        <a href="#" class="logo"><img src="images/logo.png" width="98" height="44" alt=""/></a>
        2015-08-12&nbsp;&nbsp;欢迎您，张三
        <a href="#">退出</a>
    </p>
</div>
<div class="content">
    <div class="qh">
        <p class="choice">
            <a href="#" class="active">待养护</a>
            <a href="#">已养护</a>
        </p>
    </div>
    <div class="list show">
        <div class="sx">
            <p class="time">
                <a href="#" class="today">今天</a>
                <a href="#" class="tom">明天</a>
            </p>
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
                    <col width="15%">
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
                </tr>
                <tr>
                    <td><a href="#">01234567</a></td>
                    <td><a href="#">9:00</a> </td>
                    <td><a href="#">机油三滤</a></td>
                    <td><a href="#">¥850.00</a></td>
                    <td><a href="#">沙坪坝黄角园111号</a></td>
                    <td><a href="#">张先生</a></td>
                    <td><a href="#">13356987564</a></td>
                </tr>
                <tr>
                    <td><a href="#">01234567</a></td>
                    <td><a href="#">9:00</a> </td>
                    <td><a href="#">机油三滤</a></td>
                    <td><a href="#">¥850.00</a></td>
                    <td><a href="#">沙坪坝黄角园111号</a></td>
                    <td><a href="#">李先生</a></td>
                    <td><a href="#">13356987564</a></td>
                </tr>

                </tbody>
            </table>
            <div class="page">
                <a href="#">上一页</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#">8</a>
                <a href="#">下一页</a>
                <span>共100笔记录</span>
            </div>
        </div>
    </div>
    <div class="list">
        <div class="sx">
            <p class="time">
                <a href="#" class="today">本周</a>
                <a href="#" class="tom">本月</a>
                <a href="#" class="tom">全年</a>
            </p>
        </div>
        <div class="biao">
            <table>
                <colgroup>
                    <col width="30%">
                    <col width="30%">
                    <col width="40%">
                </colgroup>
                <tbody>
                <tr>
                    <th>养护完成时间</th>
                    <th>订单号</th>
                    <th>养护项目</th>
                </tr>
                <tr>
                    <td><a href="#">2015-08-11</a></td>
                    <td><a href="#">01234567</a> </td>
                    <td><a href="#">机油三滤</a></td>
                </tr>
                <tr>
                    <td><a href="#">2015-08-11</a></td>
                    <td><a href="#">01234567</a> </td>
                    <td><a href="#">机油三滤</a></td>
                </tr>

                </tbody>
            </table>
            <div class="page">
                <a href="#">上一页</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#">8</a>
                <a href="#">下一页</a>
                <span>共100笔记录</span>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".choice a").click(function(){
                var self = $(this);
                indexI = self.index();
                self.addClass("active").siblings().removeClass("active");
                self.parent().parent().parent().children(".list").eq(indexI).addClass("show").siblings().removeClass("show");
            })
        })
    </script>
