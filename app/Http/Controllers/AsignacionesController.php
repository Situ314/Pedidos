<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\EstadoPedido;
use App\Item;
use App\Pedido;
use App\TipoCategoria;
use App\Unidad;
use App\User;
use Illuminate\Http\Request;

use Session;
class AsignacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('asig');
    }
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
     * Metodo que guardara el pedido en la tabla de items_entregado que es la ultima tabla de pedidos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$array_estado_pedido = [
            'user_id'=>$request->responsable_id,
            'estado_id'=>2,
            'pedido_id'=>$request->pedido_responsable_id
        ];

        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        $array_asignacion = [
            'asignado_id'=>$request->responsable_id,
            'pedido_id'=>$request->pedido_responsable_id
        ];

        $asignado = new Asignacion($array_asignacion);
        $asignado->save();

        Session::flash('success', "Asignacion realizada correctamente...");
        return redirect()->back();*/

        dd($request->all());

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
        $pedido = Pedido::find($id);

        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();
        $usuarios = User::all()
            ->where('rol_id','=',4);

        return view('asignador.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)
            ->withUsers($usuarios)

            ->withPedido($pedido);
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
        dd($request->all(),$id);
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
