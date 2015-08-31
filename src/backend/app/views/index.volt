<!DOCTYPE html>
<html lang="zh">
    <head>
        {{ partial('layouts/head') }}
        <link rel="stylesheet" href="{{url('assets/css/dashboard.css')}}">
    </head>
    <body>
        {{ partial('layouts/nav') }}
        {{ content() }}
    </body>
</html>
