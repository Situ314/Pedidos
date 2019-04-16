<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
    </head>

    <body>
        <h1>@yield('content-title')</h1>

        <hr/>

        <span>
            @yield('content-message')
        </span>

        <hr/>

        @yield('content-optional')

        <hr/>

        @yield('content-footer')
    </body>
</html>
