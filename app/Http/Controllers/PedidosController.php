<?php

namespace App\Http\Controllers;

use App\Area;
use App\Categoria;
use App\Empresa;
use App\ItemTemporalPedido;
use App\Pedido;
use App\Proyecto;
use App\TipoCategoria;
use App\Unidad;
use Illuminate\Http\Request;

class PedidosController extends Controller
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
        $areas = Area::orderBy('nombre');
        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();

//        dd($areas->pluck('nombre','id'));
        return view('pedidos.create')
            ->withAreas($areas)
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array_empresas = explode('|',$request->empresa_id);
        $empresa_id = $array_empresas[0];
        if(Empresa::find($empresa_id)==null){
            $array_empresas = [
                'id' =>$empresa_id,
                'nombre'=>$array_empresas[1],
                'descripcion'=>$array_empresas[2]
            ];
            $empresa = new Empresa($array_empresas);
            $empresa->save();
        }

        $array_proyecto = explode('|', $request->proyecto_id);
        $proyecto_id = $array_proyecto[0];

        if(Proyecto::find($array_proyecto[0])==null){
            $array_proyecto = [
                'id'=>$array_proyecto[0],
                'nombre'=>$array_proyecto[1],
                'descripcion'=>$array_proyecto[2],
                'empresa_id'=>$empresa_id
            ];
            $proyecto = new Proyecto($array_proyecto);
            $proyecto->save();
        }
        print_r($array_empresas);
        print_r($array_proyecto);

        $array_pedido = [
            'area_id'=>$request->area_id,
            'proyecto_id'=>$proyecto_id,
            'tipo_categoria_id'=>$request->tipo_cat_id
        ];
        $pedido = new Pedido($array_pedido);
        $pedido->save();

        for($i=0;$i<count($request->txtItem);$i++){
            if($request->txtItem[$i]==""){
                $item_temp = [

                ];
            }else{
                $array_item_temp = [
                    'cantidad'=>$request->cantidad[$i],
                    'pedido_id'=>$pedido->id,
                    'item_temp_id'=>
                ];
                $items_temp = new ItemTemporalPedido()
            }
        }
        dd($array_empresas,$array_proyecto,$request->all());

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
}
