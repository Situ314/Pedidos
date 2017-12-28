<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Unidad</th>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    <tr>
        <th scope="row">1</th>
        <td><input name="txtUnidad[]" id="txtUnidad0" class="hidden"/>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), null, ['class'=>'js-placeholder-single', 'required'=>'true','id'=>'unidad_id0','onchange'=>'javascript:cambiarTextoUnidad(0);']) }}</td>
        <td>{{ Form::number('cantidad[]', null, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true', 'min'=>'0.1']) }}</td>
        <td id="td0" data-content="0"><input name='txtItem[]' id="txtItem0" type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'>{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required', 'id'=>'item_id0', 'onchange'=>'javascript:cambiarUnidad(0);']) }}</td>
        <td><a class="editar btnCambiarEditSelect disabled" onclick="javascript:editarCampo(0);"><i id="i0" class="fa fa-edit"></i></a></td>
    </tr>
    </tbody>
</table>


