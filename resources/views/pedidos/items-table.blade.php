<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Unidad</th>
        <th>Cant. Solicitada</th>
        <th>Descripción</th>
        <th>
            <button type="button" onclick="javascritp:agregarItem();" class="btn btn-sm btn-success-custom">
                <i class="fa fa-plus"></i>
            </button>
        </th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    <tr>
        <th scope="row">1</th>
        <td>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), null, ['class'=>'js-placeholder-single', 'required'=>'true']) }}</td>
        <td>{{ Form::number('cantidad[]', null, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
        <td>{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required'=>'true']) }}</td>
        <td></td>
    </tr>
    </tbody>
</table>

