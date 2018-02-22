@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    <div>
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user-secret"></i> Autorizadores <small>Listado de autorizadores y usuarios responsables</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Autorizadores</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Usuarios</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            @include('admin.autorizadores.table-autorizadores')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            @include('admin.autorizadores.table-users')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--MODALS -->
    @include('admin.autorizadores.modals.modal-update-autorizadores')
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            updateAut: "{{route('update.autorizadores', ['id'=>':id'])}}",
            getAut: "{{route('post.autorizadores',['id'=>':id'])}}",

            token: "{{Session::token()}}"
        };
    </script>
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/admin/modal-edit-aut.js') }}
@endsection