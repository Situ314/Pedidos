<?php

namespace App\Http\Controllers;

use App\Documentos;
use App\EstadoPedido;
use App\SalidaAlmacen;
use App\SalidaAlmacenTic;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * METODO QUE SE USAR PARA EL SUBID DE ARCHIVOS DE ALMACEN.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'documento' => 'required|mimes:jpg,jpeg,png,pdf'
        ));

        if(Auth::user()->rol_id == 11){
            $salida = SalidaAlmacenTic::find($request->salida_id);

            $array_documento = [
                'nombre'=>$request->documento->getClientOriginalName(),
                'mime'=>$request->documento->getClientMimeType(),
                'ubicacion'=>$request->documento,
                'salida_tic_id'=>$request->salida_id,
                'pedido_id'=>$salida->pedido_id,
                'tipo_documento_id'=>3
            ];
            $doc = new Documentos($array_documento);
            $doc->save();

            //VERIFICA SI YA SE SUBIERON TODOS LOS DOCUMENTOS PARA LAS SALIDAS Y SI NO FALTA ALGUNA SALIDA
            $pedido = $doc->salida_tic->pedido;

            $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                ->select('t1.estado_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })

                ->whereNull('t2.id')
                ->where('t1.pedido_id','=',$pedido->id)
                ->first();

            $mensaje = "subido correctamente...";
            if($estados_pedidos_id_array->id == 5){ //ESTADO EN ENTREGADOS
                //VERIFICAR SI TODOS LOS DOCUMENTOS ESTAN
                $salidas = SalidaAlmacenTic::select('id')
                    ->where('salida_almacen_tic.pedido_id','=',$pedido->id)
                    ->whereRaw('salida_almacen_tic.id NOT IN (SELECT documentos.salida_tic_id FROM documentos where documentos.salida_tic_id is not null)')
                    ->get();
                if(count($salidas) == 0){ //SE SUBIERON TODOS LOS ARCHIVOS
                    $array_estado_pedido = [
                        'user_id'=>Auth::id(),
                        'estado_id'=>8,
                        'pedido_id'=>$pedido->id
                    ];
                    $estado_pedido = new EstadoPedido($array_estado_pedido);
                    $estado_pedido->save();

                    $mensaje = "subido correctamente, pedido finalizado...";
                }
            }
        }else{
            $salida = SalidaAlmacen::find($request->salida_id);

            $array_documento = [
                'nombre'=>$request->documento->getClientOriginalName(),
                'mime'=>$request->documento->getClientMimeType(),
                'ubicacion'=>$request->documento,
                'salida_id'=>$request->salida_id,
                'pedido_id'=>$salida->pedido_id,
                'tipo_documento_id'=>1
            ];
            $doc = new Documentos($array_documento);
            $doc->save();

            //VERIFICA SI YA SE SUBIERON TODOS LOS DOCUMENTOS PARA LAS SALIDAS Y SI NO FALTA ALGUNA SALIDA
            $pedido = $doc->salida->pedido;

            $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                ->select('t1.estado_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })

                ->whereNull('t2.id')
                ->where('t1.pedido_id','=',$pedido->id)
                ->first();

            $mensaje = "subido correctamente...";
            if($estados_pedidos_id_array->id == 5){ //ESTADO EN ENTREGADOS
                //VERIFICAR SI TODOS LOS DOCUMENTOS ESTAN
                $salidas = SalidaAlmacen::select('id')
                    ->where('salida_almacen.pedido_id','=',$pedido->id)
                    ->whereRaw('salida_almacen.id NOT IN (SELECT documentos.salida_id FROM documentos where documentos.salida_id is not null)')
                    ->get();
                if(count($salidas) == 0){ //SE SUBIERON TODOS LOS ARCHIVOS
                    $array_estado_pedido = [
                        'user_id'=>Auth::id(),
                        'estado_id'=>8,
                        'pedido_id'=>$pedido->id
                    ];
                    $estado_pedido = new EstadoPedido($array_estado_pedido);
                    $estado_pedido->save();

                    $mensaje = "subido correctamente, pedido finalizado...";
                }
            }
        }

        Session::flash('success', "Documento con nombre ".$doc->nombre." ".$mensaje);
        return redirect()->action('PedidosController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postDocs(Request $request){
        try {
            $documentos = Documentos::where('pedido_id', '=', $request->id)
//            ->where('tipo_documento_id','=',2)
                ->get();

            foreach ($documentos as $documento) {
                $documento->size = Storage::disk('local')->size($documento->ubicacion);
            }
            return response()->json(
                $documentos
            );
        }
        catch (\Exception $e){
            return response()->json(
                ['error' => 'error_documentos']
            );
        }
    }

    public function getDocumento($id){
        $documento = Documentos::find($id);
        $ubicacion = storage_path('app/'.$documento->ubicacion);
        //dd($ubicacion);
        return response()->download($ubicacion,$documento->nombre);
    }

    public function getFile($id){

        $documento = Documentos::where('id', '=', $id)->first();
        $file = Storage::disk('local')->get($documento->ubicacion);
       // dd($file);
        return (new Response($file, 200))
            ->header('Content-Type', $documento->mime);
    }
}
