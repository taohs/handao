<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>养护</title>
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.css')}}">
    <script type="text/javascript" src="{{url('assets/js/jquery1.42.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".choice a").click(function () {
                var self = $(this);
                indexI = self.index();
                self.addClass("active").siblings().removeClass("active");
                self.parent().parent().parent().children(".list").eq(indexI).addClass("show").siblings().removeClass("show");
            })
        })
    </script>
</head>

<body>
<div class="top">
    <p>
        <a href="/index/index" class="logo"><img src="{{url('assets/images/logo.png')}}" width="98" height="44" alt=""/></a>
        2015-08-12&nbsp;&nbsp;欢迎您，张三
        <a href="/index/logout">退出</a>
    </p>
</div>