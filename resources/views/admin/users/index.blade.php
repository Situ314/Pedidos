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
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyUsers">
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                @if(count($user->empleado)!=0)
                                    {{ $user->empleado->nombre_completo }}
                                @else
                                    <label class="label label-danger">Sin empleado</label>
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if(count($user->empleado)!=0)
                                    {{ $user->empleado->laboral_empleado->email_corporativo }}
                                @else
                                    <label class="label label-danger">Sin empleado</label>
                                @endif
                            </td>
                            <td>{{ $user->rol->nombre }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-info-custom" onclick="javascript:updateUsuario({{$user->id}});" title="Editar usuario {{ $user->username }}"><i class="fa fa-edit"></i></button>
                                    @if($user->deleted_at == null)
                                        <button type="button" class="btn btn-sm btn-danger-custom" onclick="javascript:updateUsuario({{$user->id}});" title="Deshabilitar usuario {{ $user->username }}"><i class="fa fa-lock"></i></button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-success-custom" onclick="javascript:updateUsuario({{$user->id}});" title="Habilitar usuario {{ $user->username }}"><i class="fa fa-unlock"></i></button>
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
            update: "{{ route('usuario.update',['id'=>':id']) }}",
            edit: "{{ route('usuario.edit',['id'=>':id']) }}",

            token: "{{Session::token()}}"
        };
    </script>
@endsection
