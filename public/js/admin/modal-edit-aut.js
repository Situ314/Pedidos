/**
 * Created by djauregui on 20/2/2018.
 */
$( document ).ready(function(){
    $(".js-placeholder-single").select2({
        allowClear: true,
        placeholder: "Seleccione ...",
        width: '100%'
    }).val('').trigger('change');
});

function editarAutorizadores(id) {
    var route = rutas.getAut.replace(':id',id);
    var token = rutas.token;

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        data:{
            id: id
        },
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        var array_autorizadores = [];
        for(var i=0 ; i<response.length ; i++){
            array_autorizadores.push(response[i].autorizador_id);
        }
        $('select[name^=autorizador_id]').select2({
            allowClear: true,
            placeholder: "Seleccione ...",
            width: '100%'
        }).val(array_autorizadores).trigger('change');
        $('#formUpdateAutorizador').prop('action',rutas.updateAut.replace(':id',id));
        $('#modalUpdateAutorizador').modal('show');
    });


}