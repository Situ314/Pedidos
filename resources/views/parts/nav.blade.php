<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a class="site_title"><i class="fa fa-location-arrow" style="margin-left: -6px;"></i> <span>SCSP</span></a>
        </div>

        <div class="clearfix"></div>
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Rol: {{\Illuminate\Support\Facades\Auth::user()->rol->nombre}} ({{\Illuminate\Support\Facades\Auth::user()->username}})</h3>
            </div>

            <!-- ADMINISTRADOR -->
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id <= 2)
                <div class="menu_section">
                    <h3>Administración</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-group"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('admin-usuarios.index') }}">Listado</a></li>
                                <li><a href="{{route('admin-autorizadores.index')}}">Autorizadores</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
            <!-- END ADMINISTRADOR -->
            <!-- AUTORIZADOR -->
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 5)
                <div class="menu_section">
                    <h3>AUTORIZADOR</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-group"></i> Mis usuarios <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('autorizador.index')}}">Listado</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
            <!-- -->
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id < 5)
                    <li>
                        <a href="{{route('dash.index')}}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    @endif
                    <li>

                    </li>
                    <li>
                        <a><i class="fa fa-space-shuttle"></i> Pedidos <span class="fa fa-chevron-down">
                            </span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('pedidos.create')}}">Crear</a></li>
                            <li><a href="{{route('pedidos.index')}}">Listado</a></li>
                        </ul>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4 || \Illuminate\Support\Facades\Auth::user()->rol_id == 7)
                        <li>
                            <a href="{{ route('responsable.index') }}"><i class="fa fa-print"></i> Impresiones</a>
                        </li>
                    @endif

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
                    <a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @if(count(Auth::user()->empleado)!=0)
                            {{ Auth::user()->empleado->nombres." ".Auth::user()->empleado->apellido_1 }}
                        @else
                            {{ Auth::user()->username }}
                        @endif
                       <span class=" fa fa-angle-down"></span>
                   </a>
                   <ul class="dropdown-menu dropdown-usermenu pull-right">
                       <li>
                           <a href="{{ route('cambiar-pass.edit', \Illuminate\Support\Facades\Auth::id()) }}" >
                                <i class="fa fa-lock pull-right"></i>  Cambiar Contraseña
                            </a>
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