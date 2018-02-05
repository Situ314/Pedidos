/**
 * Created by djauregui on 1/2/2018.
 */
$( document ).ready(function() {
    $('.js-placeholder-single').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
    $('select[name=rol_id]').change(function () {
        if($('select[name=rol_id] option:selected').val()==6){ //USUARIO
            $('.divAutorizador').removeClass("hidden");
            $('select[name=autorizador_id]').prop('required',true);
        }else{
            $('.divAutorizador').addClass("hidden");
            $('select[name=autorizador_id]').prop('required',false);
        }
    });

    var $rows = $('#tbodyUsers tr');
    $('#txtBuscarUsuario').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

});

function updateUsuario(id) {
    $('#modalHeaderUser').removeClass("modal-header-success");
    $('#modalHeaderUser').addClass("modal-header-info");

    var action = rutas.update;
    action = action.replace(':id',id);

    $('#formUpdateUser').attr("action",action);

    var route = rutas.edit;
    route = route.replace(':id',id);
    var token = rutas.token;

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        console.log(response);
        //response [0] => tiene los datos del empleado
        //response [1] => Tiene los datos del autorizador

        if(response[0].empleado != null){
            /*$('#txtEmpleadoUpdate').text(
                response.empleado.nombres+" "+response.empleado.apellido_1+" "+response.empleado.apellido_2
            );
            $('#txtEmpleadoUpdate').addClass('label-success');*/
            $('#txtEmpleadoUpdate').removeClass('label-danger');

            $('select[name=empleado_id]').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val( response[0].empleado_id ).trigger('change');
        }else{
            $('#txtEmpleadoUpdate').removeClass('label-success');
            $('#txtEmpleadoUpdate').addClass('label-danger');

            $('#txtEmpleadoUpdate').text("No asignado");

            $('select[name=empleado_id]').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val('').trigger('change');
        }

        $('input[name=username]').val( response[0].username );
        $('select[name=rol_id]').select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val( response[0].rol_id ).trigger('change');

        if(response[0].rol_id == 6){
            console.log("es usuario");
            $('select[name=autorizador_id]').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val(response[1].autorizador_id).trigger('change');
        }else{
            $('select[name=autorizador_id]').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val('').trigger('change');
        }

        $('#modalUserUpdate').modal('show');
    });

}

function crearUsuario() {
    $('input[name=username]').val('');

    $('select[name=rol_id]').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
    $('#modalUserCreate').modal('show');
}