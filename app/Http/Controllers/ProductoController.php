<?php

namespace App\Http\Controllers;

use App\Models\Producto; //Importacion del modelo Producto, a quien le pertenece este controlador
use Illuminate\Http\Request; //Se usara la clase request para manejar peticiones HTTP entrantes como envio de datos desde un formulario o API
use Illuminate\Support\Facades\Auth; //Uso de la fachada Auth para acceder al usuario autenticado actualmente
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; //Acceso al metodo authorize que se usa para aplicar politicas de autorizacion en las acciones del controlador

class ProductoController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Producto::class);
        $empresa = Auth::user()->empresa;
        $query = $empresa->productos;

        /* $perPage = $request->get('per_page',10); */
        $productos = $query;
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
