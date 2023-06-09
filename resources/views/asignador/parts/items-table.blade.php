<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Stock</th>
        <th>Unidad</th>
        <th>Tipo</th>
        <th>Tipo de Compra</th>
        <th>Especificaciones</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    @php $auxItem=0;@endphp
    @foreach($pedido->items_temp_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}<input name="item_id_edit[]" value="{{$item->id}}" hidden></th>
            <td id="td{{$auxItem}}" data-content="1"><input name='txtItem[]' id="txtItem{{$auxItem}}" type='text' class='form-control input-hg-12 items-txt text-uppercase' value="{{$item->item->nombre}}">{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2 items-temp-select2 hidden','required', 'id'=>'item_id'.$auxItem.'', 'onchange'=>'javascript:cambiarUnidad('.$auxItem.');']) }}</td>
            <td width="10%">{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
            @if($item->control_stock!="" && $item->tipo_compra!=null  && $pedido->tipo_categoria_id != 20)
                @if($item->tipo_compra->id == '3')
                    <td><label class="label label-info">NO CORRESPONDE</label></td>
                @else
                    <td>{{ Form::number('stock[]', $item->control_stock[0]->stock, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
                @endif
            @else
                <td><label class="label label-info">NO CORRESPONDE</label></td>
            @endif
            <td><input name="txtUnidad[]" id="txtUnidad{{$auxItem}}" hidden/>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'select_unidad_temp', 'required'=>'true','id'=>'unidad_id'.$auxItem.'','onchange'=>'javascript:cambiarTextoUnidad('.$auxItem.');']) }}</td>
            <td><label class="label label-warning">Item Temporal</label></td>
            @if($item->tipo_compra!=null)
                @if($item->tipo_compra->id == '3')
                    <td><label class="label label-default">{{$item->tipo_compra->nombre}}</label></td>
                @else
                    <td><label class="label label-primary">{{$item->tipo_compra->nombre}}</label></td>
                @endif
            @else
                <td><label class="label label-info">S/R</label></td>
            @endif
            <td width="30%">{{ Form::text('observaciones[]', $item->observaciones, ['class'=>'form-control input-hg-12 text-uppercase', 'step'=>'0.1']) }}</td>
            <td><a class='eliminar' onclick='javascript:eliminarFila(this);'><i class='fa fa-close'></i></a></td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    @foreach($pedido->items_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}<input name="item_id_edit[]" value="{{$item->id}}" hidden></th>
            <td id="td{{$auxItem}}" data-content="0"><input name='txtItem[]' id="txtItem{{$auxItem}}" type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'>{{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required', 'id'=>'item_id'.$auxItem.'', 'onchange'=>'javascript:cambiarUnidad('.$auxItem.');']) }}</td>
            <td>{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
            @if($item->control_stock!="" && $item->tipo_compra!=null && $pedido->tipo_categoria_id != 20)
                @if($item->tipo_compra->id == '3')
                    <td><label class="label label-info">NO CORRESPONDE</label></td>
                @else
                    <td>{{ Form::number('stock[]', $item->control_stock[0]->stock, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true','disabled']) }}</td>
                @endif
            @else
                <td><label class="label label-info">NO CORRESPONDE</label></td>
            @endif
            <td><input name="txtUnidad[]" id="txtUnidad{{$auxItem}}" hidden/>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'', 'required'=>'true','id'=>'unidad_id'.$auxItem.'','onchange'=>'javascript:cambiarTextoUnidad('.$auxItem.');']) }}</td>
            <td><label class="label label-success">Item Registrado</label></td>
            @if($item->tipo_compra!=null)
                @if($item->tipo_compra->id == '3')
                    <td><input name="tipoCompraReg[]" value={{$item->tipo_compra->id}} hidden/><label class="label label-default">{{$item->tipo_compra->nombre}}</label></td>
                @else
                    <td><input name="tipoCompraReg[]" value={{$item->tipo_compra->id}} hidden/><label class="label label-primary">{{$item->tipo_compra->nombre}}</label></td>
                @endif
            @else
                <td><label class="label label-info">S/R</label></td>
            @endif
            <td width="30%">{{ Form::text('observaciones[]', $item->observaciones, ['class'=>'form-control input-hg-12 text-uppercase', 'step'=>'0.1']) }}</td>
            <td><a class='eliminar' onclick='javascript:eliminarFila(this);'><i class='fa fa-close'></i></a></td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    </tbody>
</table>