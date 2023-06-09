<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Unidad</th>
        <th>Tipo</th>
    </tr>
    </thead>
    <tbody id="tbodyItems">
    @php $auxItem=0;@endphp
    @foreach($pedido->items_temp_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}</th>
            <td>{{$item->item->nombre}}</td>
            <td>{{$item->cantidad}}</td>
            <td>{{$item->item->unidad->full_name}}</td>
            <td><label class="label label-warning">Item Temporal</label></td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    @foreach($pedido->items_pedido as $item)
        <tr>
            <th scope="row" width="2%;">{{($auxItem+1)}}</th>
            <td>{{$item->item->nombre}}</td>
            <td>{{$item->cantidad}}</td>
            <td>{{$item->item->unidad->full_name}}</td>
            <td><label class="label label-success">Item Registrado</label></td>
        </tr>
        @php $auxItem++; @endphp
    @endforeach
    </tbody>
</table>