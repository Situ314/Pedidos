<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<title>{{ config('app.name', 'Correspondencia') }}</title>--}}
    <title>Pedidos</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="http://localhost:5004/bootstrap.css" rel="stylesheet">

    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    {{ Html::style('css/bootstrap.min.css') }}

    <!-- Bootstrap -->
    {{ Html::style('css/bootstrap.min.css') }}

    <!-- Fontawesome -->
    {{ Html::style('css/font-awesome.min.css') }}

    <!-- bootstrap-daterangepicker -->
    {{ Html::style('css/daterangepicker.css') }}

    <!-- iCheck -->
    {{ Html::style('css/iCheck/skins/flat/green.css') }}

    {{ Html::style('css/nprogress.css') }}

    <!-- Template CSS -->
    {{ Html::style('css/custom.min.css') }}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">


    {{ Html::style('css/util.css') }}

<!-- Template CSS -->
    {{ Html::style('css/main.css') }}
    <link rel="icon" href="{!! asset('images/tepco_ico.ico') !!}"/>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="login-body">
<div id="app">
    @yield('content')
</div>

<!-- Scripts -->
<script src="/js/jquery.js"></script>
<script src="/js/app.js"></script>
{{--<script src="/js/main.js"></script>--}}

<!--===============================================================================================-->
{{--<script src="vendor/jquery/jquery-3.2.1.min.js"></script>--}}
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>

{{ Html::script('/js/login.js') }}
</body>
</html>
