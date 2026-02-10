<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests; //trait para manejar su policy asociada

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Categoria::class);

        $empresa = Auth::user()->empresa; //obtiene la empresa del usuario autenticado
        $query = $empresa->categorias(); //obtiene las categorias del usuario autenticado

        // Aplicar filtros de búsqueda
        if ($request->filled('search')) { //Con el metodo filled comprueba que exista la llave y el valor, es decir que search venga en el objeto request y aparte traiga un valor consigo
            $search = $request->search; //accede al valor de search y lo asigna a la variable del mismo nombre
            $query->where(function($q) use ($search) { //q es el nombre de una subconsulta, es decir un parentesis dentro de la consulta princial. Se usa 'use' para pasar la variable search dentro de la subconsulta
                $q->where('nombreCategoria', 'like', "%{$search}%") //Busca si hay coincidencia entre el parametro de busqueda y el nombre o la descripcion de la categoria
                  ->orWhere('descripcionCategoria', 'like', "%{$search}%");
            });
        }

        // Filtro por icono (tiene icono o no)
        if ($request->filled('has_icon')) { //pregunta si el objeto request viene con un objeto de llave has_icon y si tiene contenido
            if ($request->has_icon === 'with') {  //pregunta si se escogio la opcion de traer a los que tienen icono y los trae
                $query->whereNotNull('iconoCategoria');
            } elseif ($request->has_icon === 'without') { //pregunta si se escogio la opcion de traer sin icono
                $query->whereNull('iconoCategoria'); //trae a las categorias que no cuenten con icono
            }
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombreCategoria'); //obtiene el valor de la clave sort_by o usa el valor por defecto y lo almacena en la variable $sort_by
        $sortOrder = $request->get('sort_order', 'asc'); //obtiene el valor de la clave sort_order o usa el valor por defecto

        $allowedSorts = ['nombreCategoria', 'created_at', 'updated_at']; //crea un array donde coloca las columnas disponibles para ordenar por ellas
        if (in_array($sortBy, $allowedSorts)) { //pregunta si el valor de sortBy se encuentra dentro del arreglo de disponibles
            $query->orderBy($sortBy, $sortOrder); //si se encuentra en la consulta principal ordena por la columna y usa el tipo de orden
        } else {
            $query->orderBy('nombreCategoria', 'asc'); //si el valor de la clave sortBy no se encuentra dentro del arreglo de disponibles entonces usa el valor por defecto
        }

        // Paginación
        $perPage = $request->get('per_page', 10); //obtiene el valor de la clave per page para paginar o usa el valor por defecto si la clave regresa sin valor o no existe
        $perPage = in_array($perPage, [5, 10, 25, 50]) ? $perPage : 10; //pregunta si el valor recibido de per page se encuentra dentro de un vector de disponibles y si no usa el valor por defecto que es 10
        //appends es un metodo para añadir parametros a la URL
        $categorias = $query->withCount('productos')->paginate($perPage)->appends($request->except('page')); //Cuenta cuentos productos tiene la categoría, los pagina segun lo definido y a cada boton de paginacion le añade la informacion de la url menos el numero de pag por q eso se añade cuando se usa el boton
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Categoria::class);

        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Categoria::class);

        $validated = $request->validate([
            'nombreCategoria' => 'required|string|max:100',
            'descripcionCategoria' => 'nullable|string|max:500',
            'iconoCategoria' => 'nullable|string|max:100'
        ]);

        $validated['idEmpresa'] = Auth::user()->empresa->idEmpresa;

        $categoria = Categoria::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente',
                'redirect' => route('categorias.index')
            ]);
        }

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $this->authorize('view', $categoria);

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria);

        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $this->authorize('update', $categoria);

        $validated = $request->validate([
            'nombreCategoria' => 'required|string|max:100',
            'descripcionCategoria' => 'nullable|string|max:500',
            'iconoCategoria' => 'nullable|string|max:100'
        ]);

        $categoria->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoría actualizada exitosamente',
                'redirect' => route('categorias.index')
            ]);
        }

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);

        try {
            // Verificar si tiene productos asociados
            if ($categoria->productos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la categoría porque tiene productos asociados'
                ], 400);
            }

            $categoria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoría: ' . $e->getMessage()
            ], 500);
        }
    }
}

