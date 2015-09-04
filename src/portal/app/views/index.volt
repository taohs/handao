<!DOCTYPE html>
<html>
    <head>

        {{ partial('layouts/head') }}
    </head>
    <body>

    {{ partial('layouts/header') }}
        {{ content() }}
    {{ partial('layouts/footer') }}
    </body>
</html>
