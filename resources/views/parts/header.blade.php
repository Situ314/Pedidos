<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>Pedidos </title>
<link rel="icon" href="{!! asset('images/tepco_ico.ico') !!}"/>
<link href="/css/style.css" rel="stylesheet">
<link href="http://localhost:5004/bootstrap.css" rel="stylesheet">

<style>
    @-webkit-keyframes argh-my-eyes {
        0%   { background-color: #2a3f54; }
        49% { background-color: #2a3f54; }
        50% { background-color: #6a0d02; }
        99% { background-color: #6a0d02; }
        100% { background-color: #2a3f54; }
    }
    @-moz-keyframes argh-my-eyes {
        0%   { background-color: #2a3f54; }
        49% { background-color: #2a3f54; }
        50% { background-color: #6a0d02; }
        99% { background-color: #6a0d02; }
        100% { background-color: #2a3f54; }
    }
    @keyframes argh-my-eyes {
        0%   { background-color: #2a3f54; }
        49% { background-color: #2a3f54; }
        50% { background-color: #6a0d02; }
        99% { background-color: #6a0d02; }
        100% { background-color: #2a3f54; }
    }
</style>
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