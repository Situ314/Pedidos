<!DOCTYPE html>
<html lang="es">
<head>
    @include('parts.header')
    @yield('headerScripts')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

    @include('parts.nav')

    <!-- page content -->
        <div class="right_col" role="main">
            @include('parts.messages')

            @yield('content')
            <div class="clearfix"></div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="text-center">
                <a href="#">&COPY; 2017 Pragma Invest S.A</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

    @include('modals.modal-autorizadores')
</div>

@include('parts.javascript')
<script type="text/javascript">
    var configGlobal = {
        rutas:[
            {
                getCantidades: "{{route('pedidos.cantidad')}}",
                postAutorizadores: "{{route('dash.mis.aut')}}",
                token: "{{Session::token()}}"
            }
        ]
    };
</script>

@yield('footerScripts')
</body>
</html>