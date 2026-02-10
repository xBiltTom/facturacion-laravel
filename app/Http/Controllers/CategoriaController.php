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
        if ($request->filled('has_icon')) {
            if ($request->has_icon === 'with') {
                $query->whereNotNull('iconoCategoria');
            } elseif ($request->has_icon === 'without') {
                $query->whereNull('iconoCategoria');
            }
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombreCategoria');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSorts = ['nombreCategoria', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('nombreCategoria', 'asc');
        }

        // Paginación
        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50]) ? $perPage : 10;

        $categorias = $query->withCount('productos')->paginate($perPage)->appends($request->except('page'));

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

