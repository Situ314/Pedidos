<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Unidad</th>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Tipo</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    @php $auxItem=0;@endphp
    @foreach($pedido->items_entrega as $item)
        <tr>
            <th scope="row">{{($auxItem+1)}}<input name="item_id_edit[]" value="{{$item->id}}" hidden></th>
            <td><input name="txtUnidad[]" id="txtUnidad{{$auxItem}}" hidden/>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'', 'required'=>'true','id'=>'unidad_id'.$auxItem.'','onchange'=>'javascript:cambiarTextoUnidad('.$auxItem.');']) }}</td>
            <td>{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
            <td id="td{{$auxItem}}" data-content="0"><input name='txtItem[]' id="txtItem{{$auxItem}}" type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'>{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required', 'id'=>'item_id'.$auxItem.'', 'onchange'=>'javascript:cambiarUnidad('.$auxItem.');']) }}</td>
            <td><label class="label label-success">Item Registrado</label></td>
            <td><a class='eliminar' onclick='javascript:eliminarFila(this);'><i class='fa fa-close'></i></a></td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    </tbody>
</table>