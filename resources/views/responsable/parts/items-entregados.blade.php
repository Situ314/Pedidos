<table class="table table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>Unidad</th>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Observación</th>
        <th>Entrega</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    @php $auxItem=0;@endphp
    @foreach($pedido->items_entrega as $item)
        <tr>
            <th scope="row" width="2%;">{{($loop->iteration)}}<input name="item_id_edit[]" value="{{$item->id}}" hidden></th>
            <td width="15%;">
                <input name="txtUnidad[]" id="txtUnidad{{$loop->index}}" hidden/>
                {{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'', 'required'=>'true','id'=>'unidad_id'.$loop->index.'','onchange'=>'javascript:cambiarTextoUnidad('.$loop->index.');']) }}
            </td>
            <td width="10%;">
                {{ Form::text('cantidad_guardada[]', $item->cantidad, ['class'=>'hidden']) }}
                {{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','min'=>'0.1','max'=>$item->cantidad,'required'=>'true','id'=>'numCantidad'.$loop->index]) }}
            </td>
            @if($item->item->confirmado==0)
                <td>
                    <input name='txtItem[]' id="txtItem{{$loop->index}}" type='text' class='form-control input-hg-12 items-txt text-uppercase' value="{{$item->item->nombre}}">
                </td>
            @else
                <td id="td{{$loop->index}}" data-content="0">
                    <input name='txtItem[]' id="txtItem{{$loop->index}}" type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'>
                    {{ Form::select('item_id[]', array(null), null, ['class'=>'items-select2','required', 'id'=>'item_id'.$loop->index.'', 'onchange'=>'javascript:cambiarUnidad('.$loop->index.');']) }}
                </td>
            @endif
            {{--<td><label class="label label-success">Item Registrado</label></td>--}}
            {{--<td><a class='eliminar' onclick='javascript:eliminarFila(this);'><i class='fa fa-close'></i></a></td>--}}
            <td>
                {{ Form::text('observacion[]', null, ['class'=>'form-control text-uppercase', 'id'=>'inputObs'.$loop->index]) }}
            </td>
            <td width="10%;">
                <input name="input_radio_entrega[]" id="inputRadio{{$loop->index}}" value="0" hidden>
                <input type="checkbox" id="radio_entrega_{{$loop->index}}" class="icheck_class">
            </td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    </tbody>
</table>