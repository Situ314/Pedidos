<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemPedidoEntregado;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use App\TipoCategoria;
use App\Unidad;
use Illuminate\Http\Request;
use App\Empresa;
use App\User;
use App\Estado;

use Session;
use Response;
use DB;
class ReporteController extends Controller
{
    /**
     * Función para el Reporte General
     *
     * @return \Illuminate\Http\Response
     */
    public function getGeneral(Request $request)
    {
        $empresas = Empresa::all();
        $usuarios = User::where('id','NOT LIKE','1')
                    ->where('id','NOT LIKE','2')
                    ->get();
        $estados = Estado::all();
        $autorizadores = User::where('rol_id','LIKE','5')
                    ->get();

        $responsables = User::where('rol_id','LIKE','4')
            ->get();

        $pedidos = Pedido::all();

        $items = Item::all();

        $tipos = TipoCategoria::all();

        return view('reportes.general')
            ->with('empresas',$empresas)
            ->with('usuarios',$usuarios)
            ->with('autorizadores',$autorizadores)
            ->with('estados',$estados)
            ->with('responsables',$responsables)
            ->with('items',$items)
            ->with('tipos',$tipos)
            ->with('pedidos',$pedidos);
    }

    /**
     * Función para el Reporte de Items
     *
     * @return \Illuminate\Http\Response
     */
    public function getItems(Request $request)
    {

        $empresas = Empresa::all();

        $pedidos = Pedido::all();

        $tipos = TipoCategoria::all();

        $items = Item::all();

        return view('reportes.items')
            ->with('empresas',$empresas)
            ->with('items',$items)
            ->with('tipos',$tipos)
            ->with('pedidos',$pedidos);
    }

    /**
     * Función para generar el Reporte General a partir de los Filtros
     *
     * @return \Illuminate\Http\Response
     */
    public function postFiltrado(Request $request)
    {
        $empresa = $request->empresa_id;
        $solicitante = $request->usuario_id;
        $estado = $request->estado_id;
        $autorizador = $request->autorizador_id;
        $responsable = $request->responsable_id;
        $categoria = $request->categoria_id;
        $item = $request->item_id;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $desde_entrega = $request->desde_entrega;
        $hasta_entrega = $request->hasta_entrega;

        if($empresa != 0){
            $proyecto = Proyecto::where('empresa_id','LIKE',$empresa)
                ->pluck('id');
        }else{
            $proyecto = Proyecto::orderBy('id','desc')
                ->pluck('id');
        }

        if($solicitante != 0){
            $solicitante_usuario= Pedido::where('solicitante_id','LIKE',$solicitante)
                ->pluck('id');
        }else{
            $solicitante_usuario = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($estado != 0){

            $estado_pedido = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->where('t1.estado_id','LIKE',$estado)
                ->whereNull('t2.id');

           // dd($estados_pedidos_id_array);
        }else{
            $estado_pedido = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($autorizador != 0){
            $equipo = Responsable::where('autorizador_id','LIKE',$autorizador)
                ->pluck('solicitante_id');

            $autorizador_usuario = EstadoPedido::where('estado_id','LIKE','2')
                ->where('user_id','LIKE',$autorizador)
                ->orWhere(function($query) use($equipo){
                    $query->whereIn('user_id', $equipo)
                        ->Where('estado_id',1);
                })
                ->pluck('pedido_id');


        }else{
            $autorizador_usuario = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($responsable != 0){
            $responsable_usuario = Asignacion::where('asignado_id','LIKE',$responsable)
                ->pluck('pedido_id');
        }else{
            $responsable_usuario = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($categoria != 0){
            $items_categoria = Item::where('tipo_categoria_id','LIKE',$categoria)
                ->pluck('id');

            $categoria_item_pedido = ItemPedido::whereIn('item_id', $items_categoria)
                ->pluck('pedido_id');
        }else{
            $categoria_item_pedido = Item::orderBy('id','desc')
                ->pluck('id');
        }

        if($item != 0){
            $items_pedido = ItemPedido::where('item_id','LIKE',$item)
                ->pluck('pedido_id');
        }else{
            $items_pedido = Item::orderBy('id','desc')
                ->pluck('id');
        }

        if($desde != null){
            $pedidos_desde = Pedido::where('created_at','>=',$desde)
                ->pluck('id');
        }else{
            $pedidos_desde = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($hasta != null){
            $pedidos_hasta = Pedido::where('created_at','<=',$hasta)
                ->pluck('id');
        }else{
            $pedidos_hasta = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($desde_entrega != null){
            $pedidos_desde_entrega = ItemPedidoEntregado::where('created_at','>=',$desde_entrega)
                ->pluck('pedido_id');
        }else{
            $pedidos_desde_entrega = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        if($hasta_entrega != null){
            $pedidos_hasta_entrega = ItemPedidoEntregado::where('created_at','<=',$hasta_entrega)
                ->pluck('pedido_id');
        }else{
            $pedidos_hasta_entrega = Pedido::orderBy('id','desc')
                ->pluck('id');
        }

        $pedidos = Pedido::whereIn('proyecto_id',$proyecto)
            ->whereIn('id',$solicitante_usuario)
            ->whereIn('id',$estado_pedido)
            ->whereIn('id',$autorizador_usuario)
            ->whereIn('id',$responsable_usuario)
            ->whereIn('id',$categoria_item_pedido)
            ->whereIn('id',$items_pedido)
            ->whereIn('id',$pedidos_desde)
            ->whereIn('id',$pedidos_hasta)
            ->whereIn('id',$pedidos_desde_entrega)
            ->whereIn('id',$pedidos_hasta_entrega)
            ->with('proyecto_empresa')
            ->with('solicitante_empleado')
            ->with('asignados_nombres_with_trashed')
            ->with('estados_pedido_detalle')
            ->get();
//        dd($pedidos);
        return Response::json(array(
                'pedidos' => $pedidos
            )
        );
    }

    /**
     * Función para generar el Reporte de los Items a partir de los Filtros
     *
     * @return \Illuminate\Http\Response
     */
    public function postFiltradoItems(Request $request)
    {
        $empresa = $request->empresa_id;
        $categoria = $request->categoria_id;
        $item1 = $request->item_id;
        $desde = $request->desde;
        $hasta = $request->hasta;

        $estados_pedidos = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','8');

        $items = DB::table('items as i')
            ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
            ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
            ->groupBy('i.id')
            ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
            ->get();

        $items_entregados = DB::table('items as i')
            ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta_entregados'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad_entregados'))
            ->leftjoin('items_pedido_entregado as ip','i.id','=','ip.item_id')
            ->whereIn('ip.pedido_id',$estados_pedidos)
            ->groupBy('i.id')
            ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
            ->get();

//        dd($items->all());
        $items_entregados_f = $items->map(function($d) use ($items_entregados) {
            foreach ($items_entregados as $ie){
                if($ie->id == $d->id){
                    $d->cuenta_entregados = $ie->cuenta_entregados;
                    $d->cantidad_entregados = $ie->cantidad_entregados;
                }
            }
            return $d;
        });
//        dd($items_entregados_f->all());

        $categoriasC = TipoCategoria::all();
        $unidadesC = Unidad::all();

        if($empresa != 0){
            $proyectos = Proyecto::where('empresa_id','LIKE',$empresa)
                ->get();

            foreach ($proyectos as $proyecto) {

                $items_empresa = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                    ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                    ->groupBy('i.id')
                    ->rightjoin('pedidos as p', function($join) use($proyecto)
                    {
                        $join->on('p.id', '=', 'ip.pedido_id');
                        $join->on('p.proyecto_id','=', DB::raw($proyecto->id));
                    })
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

                $items_entregados_empresa = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta_entregados'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad_entregados'))
                    ->leftjoin('items_pedido_entregado as ip','i.id','=','ip.item_id')
                    ->whereIn('ip.pedido_id',$estados_pedidos)
                    ->groupBy('i.id')
                    ->rightjoin('pedidos as p', function($join) use($proyecto)
                    {
                        $join->on('p.id', '=', 'ip.pedido_id');
                        $join->on('p.proyecto_id','=', DB::raw($proyecto->id));
                    })
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

                $items_entregados_f_empresa = $items_empresa->map(function($d) use ($items_entregados_empresa) {
                    $flag = false;
                    foreach ($items_entregados_empresa as $ie){
                        if($ie->id == $d->id){
                            $flag = true;
                            $d->cuenta_entregados = $ie->cuenta_entregados;
                            $d->cantidad_entregados = $ie->cantidad_entregados;
                        }
                    }
                    if(!$flag){
                        $d->cuenta_entregados = 0;
                        $d->cantidad_entregados = 0;
                    }
                    return $d;
                });

                if($items_entregados_f_empresa->first()->id != null){
                    foreach ($items_entregados_f as $key=>$item) {
                        $id = $item->id;
                        $flag = false;
                        foreach($items_entregados_f_empresa as $ide) {
                            if($id == $ide->id){
                                $flag = true;
                                $item->cuenta = $ide->cuenta;
                                $item->cantidad = $ide->cantidad;
                                $item->cuenta_entregados = $ide->cuenta_entregados;
                                $item->cantidad_entregados = $ide->cantidad_entregados;
                                break;
                            }
                        }
                        if(!$flag){
                            $items_entregados_f->pull($key);
                        }
                    }
                }

                $items_entregados_f = $items_entregados_f->values();

                dd($items_entregados_f);
            }
        }



        if($categoria != 0){
            $categoria_item_pedido = Item::where('tipo_categoria_id','LIKE',$categoria)
                ->pluck('id')
                ->toArray();

            foreach ($items_entregados_f as $key=>$item) {
                if (!in_array($item->id, $categoria_item_pedido)) {
                    $items_entregados_f->pull($key);
                }
            }

            $items_entregados_f = $items_entregados_f->values();
        }

        if($item1 != 0) {
            $items_pedido = Item::where('id', 'LIKE', $item1)
                ->pluck('id')
                ->toArray();

            foreach ($items_entregados_f as $key=>$item) {
                $id = $item->id;
                if (!in_array($id, $items_pedido)) {
                    $items_entregados_f->pull($key);
                }
            }

            $items_entregados_f = $items_entregados_f->values();
        }

        if($desde != null){

            if($hasta != null){
                $items_ambos = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                    ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                    ->where('ip.created_at','>=',$desde)
                    ->where('ip.created_at','<=',$hasta)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

                $items_entregados_ambos = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta_entregados'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad_entregados'))
                    ->leftjoin('items_pedido_entregado as ip','i.id','=','ip.item_id')
                    ->whereIn('ip.pedido_id',$estados_pedidos)
                    ->where('ip.created_at','>=',$desde)
                    ->where('ip.created_at','<=',$hasta)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

//            dd($items_entregados_desde);

                $items_entregados_f_ambos = $items_ambos->map(function($d) use ($items_entregados_ambos) {
                    $flag = false;
                    foreach ($items_entregados_ambos as $ie){
                        if($ie->id == $d->id){
                            $flag = true;
                            $d->cuenta_entregados = $ie->cuenta_entregados;
                            $d->cantidad_entregados = $ie->cantidad_entregados;
                        }
                    }
                    if(!$flag){
                        $d->cuenta_entregados = 0;
                        $d->cantidad_entregados = 0;
                    }
                    return $d;
                });

//            dd($items_entregados_f_desde);

                foreach ($items_entregados_f as $key=>$item) {
                    $id = $item->id;
                    $flag = false;
                    foreach ( $items_entregados_f_ambos as $ide) {
                        if($id == $ide->id){
                            $flag = true;
                            $item->cuenta = $ide->cuenta;
                            $item->cantidad = $ide->cantidad;
                            $item->cuenta_entregados = $ide->cuenta_entregados;
                            $item->cantidad_entregados = $ide->cantidad_entregados;
                            break;
                        }
                    }
                    if (!$flag) {
                        $items_entregados_f->pull($key);
                    }
                }

                $items_entregados_f = $items_entregados_f->values();// dd($items);
            }else{
                $items_desde = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                    ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                    ->where('ip.created_at','>=',$desde)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

                $items_entregados_desde = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta_entregados'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad_entregados'))
                    ->leftjoin('items_pedido_entregado as ip','i.id','=','ip.item_id')
                    ->whereIn('ip.pedido_id',$estados_pedidos)
                    ->where('ip.created_at','>=',$desde)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

//            dd($items_entregados_desde);

                $items_entregados_f_desde = $items_desde->map(function($d) use ($items_entregados_desde) {
                    $flag = false;
                    foreach ($items_entregados_desde as $ie){
                        if($ie->id == $d->id){
                            $flag = true;
                            $d->cuenta_entregados = $ie->cuenta_entregados;
                            $d->cantidad_entregados = $ie->cantidad_entregados;
                        }
                    }
                    if(!$flag){
                        $d->cuenta_entregados = 0;
                        $d->cantidad_entregados = 0;
                    }
                    return $d;
                });

//            dd($items_entregados_f_desde);

                foreach ($items_entregados_f as $key=>$item) {
                    $id = $item->id;
                    $flag = false;
                    foreach ( $items_entregados_f_desde as $ide) {
                        if($id == $ide->id){
                            $flag = true;
                            $item->cuenta = $ide->cuenta;
                            $item->cantidad = $ide->cantidad;
                            $item->cuenta_entregados = $ide->cuenta_entregados;
                            $item->cantidad_entregados = $ide->cantidad_entregados;
                            break;
                        }
                    }
                    if (!$flag) {
                        $items_entregados_f->pull($key);
                    }
                }

                $items_entregados_f = $items_entregados_f->values();// dd($items);
            }
        }else{
            if($hasta != null){
                $items_hasta = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                    ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                    ->where('ip.created_at','<=',$hasta)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

                $items_entregados_hasta = DB::table('items as i')
                    ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta_entregados'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad_entregados'))
                    ->leftjoin('items_pedido_entregado as ip','i.id','=','ip.item_id')
                    ->whereIn('ip.pedido_id',$estados_pedidos)
                    ->where('ip.created_at','<=',$hasta)
                    ->groupBy('i.id')
                    ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                    ->get();

//            dd($items_entregados_desde);

                $items_entregados_f_hasta = $items_hasta->map(function($d) use ($items_entregados_hasta) {
                    $flag = false;
                    foreach ($items_entregados_hasta as $ie){
                        if($ie->id == $d->id){
                            $flag = true;
                            $d->cuenta_entregados = $ie->cuenta_entregados;
                            $d->cantidad_entregados = $ie->cantidad_entregados;
                        }
                    }
                    if(!$flag){
                        $d->cuenta_entregados = 0;
                        $d->cantidad_entregados = 0;
                    }
                    return $d;
                });

//            dd($items_entregados_f_desde);

                foreach ($items_entregados_f as $key=>$item) {
                    $id = $item->id;
                    $flag = false;
                    foreach ( $items_entregados_f_hasta as $ide) {
                        if($id == $ide->id){
                            $flag = true;
                            $item->cuenta = $ide->cuenta;
                            $item->cantidad = $ide->cantidad;
                            $item->cuenta_entregados = $ide->cuenta_entregados;
                            $item->cantidad_entregados = $ide->cantidad_entregados;
                            break;
                        }
                    }
                    if (!$flag) {
                        $items_entregados_f->pull($key);
                    }
                }

                $items_entregados_f = $items_entregados_f->values();
            }
        }


        return Response::json(array(
                'items' => $items_entregados_f,
                'categorias' => $categoriasC,
                'unidades' => $unidadesC,
            )
        );
    }

    function myArrayContainsWord(array $myArray, $word) {
        foreach ($myArray as $element) {
            if ($element->id == $word){
            return true;
        }
        }
        return false;
    }
}
