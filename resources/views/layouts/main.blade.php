<!DOCTYPE html>
<html lang="en">
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
</div>

@include('parts.javascript')
@yield('footerScripts')

</body>
</html>