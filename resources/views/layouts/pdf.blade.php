<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pdf</title>
    <!-- Bootstrap -->
    {{ Html::style('css/bootstrap.min.css') }}

    <!-- CORRECION DE ERROR OVERLAPPING O SUPERPOSICION-->
    <style type="text/css" rel="stylesheet">
        thead { display: table-header-group }
        tfoot { display: table-row-group }
        tr { page-break-inside: avoid }
    </style>
</head>
<body>
    @yield('content')
    <!-- Scripts -->
    @yield('script')
</body>

</html>