@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    <div>
        <div class="page-title">
            <div class="title_left">
                <h3>Lista de Usuarios</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <input id="txtBuscarUsuario" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                    {{--<div class="input-group">
                        <input id="txtBuscarUsuario" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-user"></i><small>Listado de usuarios del sistema</small></h2>
            <button type="button" onclick="javascript:crearUsuario();" class="btn btn-sm btn-success-custom pull-right">+ Crear</button>
            <div class="clearfix"></div>
        </div>
        {{--<div class="x_content" style="-webkit-flex: 1 1 auto; overflow-y: auto; height: 500px;">--}}
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        @if(\Illuminate\Support\Facades\Auth::user()->rol_id==1)
                            <th>ID</th>
                        @endif
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Correo Personal</th>
                        <th>Correo Corporativo</th>
                        <th>Estado</th>
                        <th>Rol</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyUsers">
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->rol_id==1)
                            <td>
                                @if(count($user->empleado)!=0)
                                    {{ $user->empleado->id }}
                                @else
                                    <label class="label label-danger">S/E</label>
                                @endif
                            </td>
                            @endif
                            <td>
                                @if(count($user->empleado)!=0)
                                    {{ $user->empleado->nombre_completo }}
                                @else
                                    <label class="label label-danger">S/E</label>
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if(count($user->empleado)!=0)
                                    @if($user->empleado->contacto_empleado!=null)
                                        @if(empty(trim($user->empleado->contacto_empleado->email)))
                                            <label class="label label-warning">S/C</label>
                                        @else
                                            {{ $user->empleado->contacto_empleado->email }}
                                        @endif
                                    @else
                                        <label class="label label-warning">S/C</label>
                                    @endif
                                @else
                                    <label class="label label-danger">S/E</label>
                                @endif
                            </td>
                            <td>
                                @if(count($user->empleado)!=0)
                                    @if($user->empleado->laboral_empleado!=null)
                                        @if(empty(trim($user->empleado->laboral_empleado->email_corporativo)))
                                            <label class="label label-warning">S/C</label>
                                        @else
                                            {{ $user->empleado->laboral_empleado->email_corporativo }}
                                        @endif
                                    @else
                                        <label class="label label-warning">S/C</label>
                                    @endif
                                @else
                                    <label class="label label-danger">S/E</label>
                                @endif
                            </td>
                            <td>
                                @if(count($user->empleado)!=0)
                                    @if($user->empleado->estado=='Activo')
                                        <label class="label label-success">{{$user->empleado->estado}}</label>
                                    @elseif($user->empleado->estado=='Inactivo')
                                        <label class="label label-danger">{{$user->empleado->estado}}</label>
                                    @elseif($user->empleado->estado=='Externo')
                                        <label class="label label-info">{{$user->empleado->estado}}</label>
                                    @endif

                                @else
                                    <label class="label label-danger">S/E</label>
                                @endif
                            </td>
                            <td>{{ $user->rol->nombre }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($user->deleted_at == null)
                                        <button type="button" class="btn btn-sm btn-danger-custom col-xs-6" onclick="javascript:deshabilitarUsuario({{$user->id}});" title="Deshabilitar usuario {{ $user->username }}"><i class="fa fa-lock"></i></button>
                                        <button type="button" class="btn btn-sm btn-info-custom col-xs-6" onclick="javascript:updateUsuario({{$user->id}});" title="Editar usuario {{ $user->username }}"><i class="fa fa-edit"></i></button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-success-custom" onclick="javascript:habilitarUsuario({{$user->id}});" title="Habilitar usuario {{ $user->username }}"><i class="fa fa-unlock"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{--AGREGANDO MODALES--}}
    @include('admin.modals.modal-user-update')
    @include('admin.modals.modal-user-create')
@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/admin/users.js') }}
{{--    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.10.2/validator.min.js') }}--}}

    <script type="text/javascript">
        var rutas = {
            update: "{{ route('admin-usuarios.update',['id'=>':id']) }}",
            edit: "{{ route('admin-usuarios.edit',['id'=>':id']) }}",
            del: "{{route('admin-usuarios.destroy',['id'=>':id'])}}",
            res: "{{route('usuario.restore',['id'=>':id'])}}",
            token: "{{Session::token()}}"
        };
    </script>
@endsection
