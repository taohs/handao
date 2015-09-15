<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->url->get('css/style.css'); ?>">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<body>
<div class="title">
    <p>
        技师登录
    </p>
</div>
<div class="login ">
    <form action="" method="post">

        <div class="container"><?php echo $this->flash->output(); ?></div>
        <p><input type="text" name="username" maxlength="20" placeholder="请输入登录账号"></p>
        <p><input type="text" name="number" maxlength="4" placeholder="请输入工牌号"></p>
        <p><input type="password" name="password" maxlength="20" placeholder="请输入登录密码"></p>

        <p class="sub">
            <input type="submit" value="登录">

            <input type="hidden" name="<?php echo $this->security->getTokenKey(); ?>"  value="<?php echo $this->security->getToken(); ?>">
        </p>

    </form>
</div>
</body>
</html>
