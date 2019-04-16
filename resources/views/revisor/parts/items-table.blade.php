<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Unidad</th>
        <th>Tipo</th>
        <th>Stock</th>
        <th>Tipo de Compra</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    @php $auxItem=0;@endphp
    @foreach($pedido->items_temp_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}<input name="item_id_temp[]" value="{{$item->id}}" hidden></th>
            <td id="td{{$auxItem}}" data-content="1"><input disabled name='txtItem[]' id="txtItem{{$auxItem}}" type='text' class='form-control input-hg-12 items-txt text-uppercase' value="{{$item->item->nombre}}">{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2 items-temp-select2 hidden','required', 'id'=>'item_id'.$auxItem.'', 'onchange'=>'javascript:cambiarUnidad('.$auxItem.');', 'disabled']) }}</td>
            <td scope="row" width="5%;">{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true', 'disabled']) }}</td>
            <td><input name="txtUnidad[]" id="txtUnidad{{$auxItem}}" hidden/>{{ Form::text('txtUnidad[]', $item->item->unidad->nombre.' ('.$item->item->unidad->descripcion.')', ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
            <td><label class="label label-warning">Item Temporal</label></td>
            @if($item->tipo_compra_id != null && $item->tipo_compra_id != '3')
                <td id="tdT{{$auxItem}}" data-content="1"><input name="idTemp[]" value="{{$item->id}}" hidden>{{ Form::number('stock_tmp[]', null,['class'=>'input-hg-12', 'required'=>'true','id'=>'stock'.$auxItem.'', 'min'=>'0']) }}</td>
            @else
                <td id="tdT{{$auxItem}}" data-content="1"><label class="label label-primary">No es un AF</label></td>
            @endif
            <td ><input name="txtCompra[]" id="txtCompra{{$auxItem}}" hidden/>{{ Form::select('tipo_compra_tmp[]', $tipo_compras->pluck('nombre', 'id'), $item->tipo_compra_id, ['class'=>'js-placeholder-single', 'required'=>'true','id'=>'unidad_id'.$auxItem.'', 'onchange'=>'cambiarTipoCompra(this,'.$auxItem.','.$item->id.')']) }}</td>

        </tr>
        @php $auxItem++; @endphp
    @endforeach
    @foreach($pedido->items_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}<input name="item_id[]" value="{{$item->id}}" hidden></th>
            <td id="td{{$auxItem}}" data-content="0">{{ Form::text('txtItem[]', $item->item->nombre, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
            <td scope="row" width="5%;">{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
            <td><input name="txtUnidad[]" id="txtUnidad{{$auxItem}}" hidden/>{{ Form::text('txtUnidad[]', $item->item->unidad->nombre.' ('.$item->item->unidad->descripcion.')', ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
            <td><label class="label label-success">Item Registrado</label></td>
            @if($item->tipo_compra_id != null && $item->tipo_compra_id != '3')
                <td id="tdT{{$auxItem}}" data-content="0"><input name="idReg[]" value="{{$item->id}}" hidden>{{ Form::number('stock[]', null,['class'=>'input-hg-12', 'required'=>'true','id'=>'stock'.$auxItem.'', 'min'=>'0']) }}</td>
            @else
                <td id="tdT{{$auxItem}}" data-content="0"><label class="label label-primary">No es un AF</label></td>
            @endif
            <td ><input name="txtCompra[]" id="txtCompra{{$auxItem}}" hidden/>{{ Form::select('tipo_compra[]', $tipo_compras->pluck('nombre', 'id'), $item->tipo_compra_id, ['class'=>'js-placeholder-single', 'required'=>'true','id'=>'tipo_compra'.$auxItem.'', 'onchange'=>'cambiarTipoCompra(this,'.$auxItem.','.$item->id.')']) }}</td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    </tbody>
</table>