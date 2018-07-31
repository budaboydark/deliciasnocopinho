<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo asset('../resources/assets/bootstrap/css/bootstrap.css'); ?>" type="text/css" />
        <script type="text/javascript" src="<?php echo asset('../resources/assets/bootstrap/js/bootstrap.js'); ?>"></script>
    </head>
    <body>
        <div class="container">
            @yield('conteudo')
        </div>
    </body>
</html>