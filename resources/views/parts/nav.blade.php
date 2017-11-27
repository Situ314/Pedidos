<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">

            {{--<img src="/images/logo3.png" style="width: 100%;">--}}
{{--            <a href="{{route('dash.index')}}" class="site_title"><i class="fa fa-envelope" style="margin-left: -6px;"></i> <span>SICC</span></a>--}}
        </div>

        <div class="clearfix"></div>


        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <!-- ADMINISTRADOR -->
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 1)
                <div class="menu_section">
                    <h3>Administración</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-group"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                {{--<li><a href="{{ route('usuarios.index') }}">Listado</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
        @endif

        <!-- END ADMINISTRADOR -->
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        {{--<a href="{{route('dash.index')}}"><i class="fa fa-dashboard"></i> Dashboard</a>--}}
                    </li>
                    <li>
                        <a><i class="fa fa-space-shuttle"></i> Pedidos <span class="fa fa-chevron-down">
                            </span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('pedidos.create')}}">Crear</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        {{--<div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="CONFIGURACIÓN">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="CERRAR SESIÓN" id="btn-logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>--}}
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav no-print">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <div class="nav_nombre_empresa">
                @yield('titulo')
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->username }}&nbsp;&nbsp;
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            {{--<a href="{{route('cambiar-pass.index')}}" >
                                <i class="fa fa-lock pull-right"></i>  Cambiar Contraseña
                            </a>--}}
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out pull-right"></i>  Cerrar Sesión
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->