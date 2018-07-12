<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Unidad</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    <tr>
        <th scope="row" width="2%;">1</th>
        <td id="td0" data-content="0"><input name='txtItem[]' id="txtItem0" type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' onkeyup="javascript:buscarItem(this.value,0);">{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required', 'id'=>'item_id0', 'onchange'=>'javascript:cambiarUnidad(0);']) }}</td>
        <td width="10%;">{{ Form::number('cantidad[]', null, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true', 'min'=>'0.1']) }}</td>
        <td width="15%;"><input name="txtUnidad[]" id="txtUnidad0" class="hidden"/>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), null, ['class'=>'js-placeholder-single', 'required'=>'true','id'=>'unidad_id0','onchange'=>'javascript:cambiarTextoUnidad(0);']) }}</td>
        <td width="10%;"><a class="editar btnCambiarEditSelect disabled" onclick="javascript:editarCampo(0);" title="Edita item 1"><i id="i0" class="fa fa-edit"></i></a></td>
    </tr>
    </tbody>
</table>


