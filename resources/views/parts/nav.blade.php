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

            <!-- RESPONSABLE NOTIFICACIONES -->
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                <div class="menu_section">
                    <h3>PEDIDOS</h3>
                    @php
                        $flag = 0;
                        $user = Illuminate\Support\Facades\Auth::user()->id;
                        $a_month_ago = Carbon\Carbon::now()->subMonth();

                         $pedidos_asignados_array = DB::table('asignaciones as t1')
                                        ->select('t1.pedido_id')
                                        ->leftJoin('asignaciones as t2',function ($join){
                                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                                ->on('t1.id', '<', 't2.id');
                                        })
                                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                                        ->where('t1.asignado_id','=',$user)
                                        ->whereNull('t2.id');

                        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                        //GET PARCIALES
                        $estados_pedidos_id_array_parciales = Illuminate\Support\Facades\DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=','4');

                        $pedidos_parciales = App\Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
                            ->whereDate('created_at','<',$a_month_ago)
                            ->orderBy('id','asc')
                            ->get();

                        //GET ASIGNADOS
                        $estados_pedidos_id_array_asignados = Illuminate\Support\Facades\DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=','3');

                        $pedidos = App\Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
                            ->whereDate('created_at','<',$a_month_ago)
                            ->orderBy('id','asc')
                            ->get();

                        if(count($pedidos)>0 || count($pedidos_parciales)>0){
                            $flag = 1;
                        }
                    @endphp
                    @if($flag == 1)
                        <ul class="nav side-menu">
                            <li style="-webkit-animation: argh-my-eyes 1s infinite;-moz-animation:argh-my-eyes 1s infinite;animation:argh-my-eyes 1s infinite;" >
                                <a href="{{route('pedidos.dashboardR')}}"><i class="fa fa-bell"></i> Tiene Pedidos Pendientes <br>({{count($pedidos)}} Asignados) ({{count($pedidos_parciales)}} Parciales)</a>
                            </li>
                        </ul>
                    @else
                        <ul class="nav side-menu">
                            <li>
                                <a href="{{route('pedidos.dashboardR')}}"><i class="fa fa-check-square-o"></i> Sin Pendientes</a>
                            </li>
                        </ul>
                    @endif
                </div>
            @endif

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
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id < 4)
                        <li>
                            <a href="{{route('pedidos.asignador')}}"><i class="fa fa-line-chart"></i> Dashboard Responsables</a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{route('reporte.general')}}"><i class="fa fa-file-text-o"></i> Reportes</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="{{route('reporte.items')}}"><i class="fa fa-file-image-o"></i> Reportes de Items</a>--}}
                        {{--</li>--}}
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id < 4)
                        <li>
                            <a><i class="fa fa-file-text-o"></i> Reportes <span class="fa fa-chevron-down">
                            </span></a>
                            <ul class="nav child_menu">
                                <li>
                                    <a href="{{route('reporte.general')}}"> Reporte General</a>
                                </li>
                                <li>
                                    <a href="{{route('reporte.items')}}"> Reportes de Items</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a><i class="fa fa-space-shuttle"></i> Pedidos <span class="fa fa-chevron-down">
                            </span></a>
                        <ul class="nav child_menu">
                            @if(\Illuminate\Support\Facades\Auth::user()->rol_id != 9)
                                <li><a href="{{route('pedidos.create')}}">Crear</a></li>
                            @endif
                            <li><a href="{{route('pedidos.index')}}">Listado</a></li>
                        </ul>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4 || \Illuminate\Support\Facades\Auth::user()->rol_id == 7)
                        <li>
                            <a href="{{ route('responsable.index') }}"><i class="fa fa-print"></i> Impresiones</a>
                        </li>
                    @endif

                    {{--<li>--}}
                        {{--<a><i class="fa fa-calendar"></i> Gestiones <span class="fa fa-chevron-down">--}}
                        {{--</span></a>--}}
                        {{--<ul class="nav child_menu">--}}
                            {{--<li><a href="{{route('pedidos.index2k18')}}">2018</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

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
                       @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 6)
                            <li>
                                <a data-toggle="modal" onclick="misAutorizadores();" >
                                    <i class="fa fa-user-secret pull-right"></i>  Mis Autorizadores
                                </a>
                            </li>
                       @endif
                       @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 3)
                           <li>
                               <a href="{{ route('parametros.index') }}" >
                                   <i class="fa fa-list-alt pull-right"></i>  Parámetros
                               </a>
                           </li>
                       @endif
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