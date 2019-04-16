<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Asignacion;
use App\EstadoPedido;
use App\ItemPedidoEntregado;
use App\Pedido;
use App\Proyecto;
use App\Empresa;
use App\User;
use App\Estado;
use App\Item;
use App\ItemPedido;
use App\TipoCategoria;
use App\Unidad;

use Excel;
use Session;
use Response;
use DB;
use File;
use Carbon\Carbon;

class ExcelController extends Controller
{
    /**
     * File Export Code
     *
     * @var array
     */
    public function downloadExcel(Request $request)
    {
        //$data = Item::get()->toArray();
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
            $autorizador_usuario = EstadoPedido::where('estado_id','LIKE','2')
                ->where('user_id','LIKE',$autorizador)
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
            ->with('estados')
            ->get();
//       dd($pedidos);

        //TRANSFORMAR EN ARRAY LO QUE ENCESITO EN EL EXCEL
        $pedidosExcel = [];
        $num = 1;
        if(count($pedidos)>0){
            foreach ($pedidos as $pedido)
            {
                $estado = $pedido->estados_pedido->sortByDesc('created_at')->first();

                if($estado != null){
                    $status = $estado->estado->nombre;
                }else{
                    $status = 'SIN ESTADO';
                }

                $pedidosExcel[] = [
                    '#' => $num,
                    'Código' => $pedido->codigo,
                    'Empresa' => $pedido->proyecto_empresa->empresa->nombre,
                    'Proyecto' => $pedido->proyecto->nombre,
                    'Solicitante' => $pedido->solicitante_empleado->empleado->nombres.' '.$pedido->solicitante_empleado->empleado->apellido_1.' '.$pedido->solicitante_empleado->empleado->apellido_2,
                    'Asignado a:' => $pedido->asignados_nombres_with_trashed->first()['empleado_nombres']['nombres'].' '.$pedido->asignados_nombres->first()['empleado_nombres']['apellido_1'].' '.$pedido->asignados_nombres->first()['empleado_nombres']['apellido_2'],
                    'Creado en:' => $pedido->created_at,
                    'Estado' => $status
                ];
                $num++;
            }

            // PARA NOMBRAR AL ARCHIVO
            $year = Carbon::now()->year;
            $month = (Carbon::now()->month <= 9)?"0".Carbon::now()->month:Carbon::now()->month;
            $day = (Carbon::now()->day <= 9)?"0".Carbon::now()->day:Carbon::now()->day;

            $hour = (Carbon::now()->hour <= 9)?"0".Carbon::now()->hour:Carbon::now()->hour;
            $minute = (Carbon::now()->minute <= 9)?"0".Carbon::now()->minute:Carbon::now()->minute;
            $second = (Carbon::now()->second <= 9)?"0".Carbon::now()->second:Carbon::now()->second;

            $reporteNombre = "Reporte_".$year.$month.$day."_".$hour.$minute.$second;


            // CREAR EXCEL
            Excel::create($reporteNombre, function($excel) use ($pedidosExcel) {
                $excel->sheet('Hoja 1', function($sheet) use ($pedidosExcel)
                {
                    $sheet->fromArray($pedidosExcel);
                    $sheet->cells('A1:H1', function($cells) {

                        $cells->setFontColor('#ffffff');
                        $cells->setFontSize(14);
                        $cells->setBackground('#2a3f54');

                    });
                });
            })->store('xlsx', public_path('excel/exports'));

            $file = $reporteNombre.'.xlsx';
            //$path = public_path('excel/exports/' . $file);
            $path = '/excel/exports/' . $file;
        }else{
            $path = '0';
        }

        return Response::json(array(
                'url' => $path
            )
        );
    }

    /**
     * File Export Code Items
     *
     * @var array
     */
    public function downloadExcelItems(Request $request)
    {
        $empresa = $request->empresa_id;
        $categoria = $request->categoria_id;
        $item1 = $request->item_id;
        $desde = $request->desde;
        $hasta = $request->hasta;

//        dd($request->all());
        $items = DB::table('items as i')
            ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
            ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
            ->groupBy('i.id')
            ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
            ->get();

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

                if($items_empresa->first()->id != null){
                    foreach ($items as $key=>$item) {
                        $id = $item->id;
                        $flag = false;
                        foreach ( $items_empresa as $ide) {
                            if($id == $ide->id){
                                $flag = true;
                                $item->cuenta = $ide->cuenta;
                                $item->cantidad = $ide->cantidad;
                                break;
                            }
                        }
                        if(!$flag){
                            $items->pull($key);
                        }
                    }
                }
//            dd($num);
            }
        }

        $items = $items->values();

        if($categoria != 0){
            $categoria_item_pedido = Item::where('tipo_categoria_id','LIKE',$categoria)
                ->pluck('id')
                ->toArray();

            foreach ($items as $key=>$item) {
                if (!in_array($item->id, $categoria_item_pedido)) {
                    $items->pull($key);
                }
            }

//            dd('entro');
        }

        if($item1 != 0) {
            $items_pedido = Item::where('id', 'LIKE', $item1)
                ->pluck('id')
                ->toArray();;

            foreach ($items as $key=>$item) {
                $id = $item->id;
                if (!in_array($id, $items_pedido)) {
                    $items->pull($key);
                }
            }
        }

        $items = $items->values();
        if($desde != null){

            $items_desde = DB::table('items as i')
                ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                ->where('ip.created_at','>=',$desde)
                ->groupBy('i.id')
                ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                ->get();
            //   dd($items);

            foreach ($items as $key=>$item) {
                $id = $item->id;
                $flag = false;
                foreach ( $items_desde as $ide) {
                    if($id == $ide->id){
                        $flag = true;
                        $item->cuenta = $ide->cuenta;
                        $item->cantidad = $ide->cantidad;
                        break;
                    }
                }
                if (!$flag) {
                    $items->pull($key);
                }
            }
            // dd($items);
        }

        $items = $items->values();

        if($hasta != null){

            $items_hasta = DB::table('items as i')
                ->select('i.*', DB::raw('COUNT(ip.item_id) as cuenta'),DB::raw('IFNULL(SUM(ip.cantidad),0) as cantidad'))
                ->leftjoin('items_pedidos as ip','i.id','=','ip.item_id')
                ->where('ip.created_at','<=',$hasta)
                ->groupBy('i.id')
                ->orderBy(DB::raw('SUM(ip.cantidad)'),'DESC')
                ->get();
            //   dd($items);

            foreach ($items as $key=>$item) {
                $id = $item->id;
                $flag = false;
                foreach ( $items_hasta as $ide) {
                    if($id == $ide->id){
                        $flag = true;
                        $item->cuenta = $ide->cuenta;
                        $item->cantidad = $ide->cantidad;
                        break;
                    }
                }
                if (!$flag) {
                    $items->pull($key);
                }
            }
        }

        $items = $items->values();
//        dd($items);
        //TRANSFORMAR EN ARRAY LO QUE ENCESITO EN EL EXCEL
        $pedidosExcel = [];
        $num = 1;
        if(count($items)>0){
            foreach ($items as $item)
            {
                $categoriaPrint = "";
                $unidadPrint = "";
                foreach ($categoriasC as $cc){
                    if($item->tipo_categoria_id == $cc->id){
                        $categoriaPrint = $cc->nombre;
                        break;
                    }
                }

                foreach ($unidadesC as $uc){
                    if($item->unidad_id == $uc->id){
                        $unidadPrint = $uc->nombre;
                        break;
                    }
                }

                if(substr($unidadPrint, -1) != 's'){
                    if($unidadPrint == 'Par'){
                        $unidadPrint = $unidadPrint.'(es)';
                    }else{
                        $unidadPrint = $unidadPrint.'(s)';
                    }
                }
                //dd(substr($categoriaPrint, -1));
                $pedidosExcel[] = [
                    '#' => $num,
                    'Nombre' => $item->nombre,
                    'Id Producto Cubo' => $item->id_producto_cubo,
                    'Tipo Producto' => $categoriaPrint,
                    '# de Pedidos' => $item->cuenta,
                    'Asignado a:' => $item->cantidad.' '.$unidadPrint,
                ];
                $num++;
            }

            // PARA NOMBRAR AL ARCHIVO
            $year = Carbon::now()->year;
            $month = (Carbon::now()->month <= 9)?"0".Carbon::now()->month:Carbon::now()->month;
            $day = (Carbon::now()->day <= 9)?"0".Carbon::now()->day:Carbon::now()->day;

            $hour = (Carbon::now()->hour <= 9)?"0".Carbon::now()->hour:Carbon::now()->hour;
            $minute = (Carbon::now()->minute <= 9)?"0".Carbon::now()->minute:Carbon::now()->minute;
            $second = (Carbon::now()->second <= 9)?"0".Carbon::now()->second:Carbon::now()->second;

            $reporteNombre = "ReporteItem_".$year.$month.$day."_".$hour.$minute.$second;


            // CREAR EXCEL
            Excel::create($reporteNombre, function($excel) use ($pedidosExcel) {
                $excel->sheet('Hoja 1', function($sheet) use ($pedidosExcel)
                {
                    $sheet->fromArray($pedidosExcel);
                    $sheet->cells('A1:F1', function($cells) {

                        $cells->setFontColor('#ffffff');
                        $cells->setFontSize(14);
                        $cells->setBackground('#2a3f54');

                    });
                });
            })->store('xlsx', public_path('excel/exports'));

            $file = $reporteNombre.'.xlsx';
            //$path = public_path('excel/exports/' . $file);
            $path = '/excel/exports/' . $file;
        }else{
            $path = '0';
        }


        return Response::json(array(
                'url' => $path
            )
        );
    }
}
