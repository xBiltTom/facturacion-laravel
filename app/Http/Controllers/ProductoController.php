<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Cloudinary\Cloudinary;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(config('cloudinary.cloud_url'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Producto::class);

        $empresa = Auth::user()->empresa;
        $productos = $empresa->productos()
            ->with(['categoria', 'unidad'])
            ->orderBy('nombreProducto', 'asc')
            ->get();

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Producto::class);

        $empresa = Auth::user()->empresa;
        $categorias = $empresa->categorias()->orderBy('nombreCategoria')->get();
        $unidades = Unidad::orderBy('nombreUnidad')->get();

        return view('productos.create', compact('categorias', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Producto::class);

        $validated = $request->validate([
            'nombreProducto' => 'required|string|max:150',
            'descripcionProducto' => 'nullable|string|max:500',
            'idCategoria' => 'required|exists:categoria,idCategoria',
            'idUnidad' => 'required|exists:unidad,idUnidad',
            'precioVentaProducto' => 'required|numeric|min:0|max:999999.99',
            'tieneIGV' => 'required|boolean',
            'stockProducto' => 'required|integer|min:0',
            'imagenProducto' => 'nullable|string'
        ]);

        try {
            $urlImagen = null;
            $idImagen = null;

            // Subir imagen a Cloudinary si existe
            if ($request->imagenProducto) {
                try {
                    $uploadResult = $this->cloudinary->uploadApi()->upload($request->imagenProducto, [
                        'folder' => 'productos',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'limit'
                        ]
                    ]);

                    $urlImagen = $uploadResult['secure_url'];
                    $idImagen = $uploadResult['public_id'];
                } catch (\Exception $uploadError) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al subir la imagen: ' . $uploadError->getMessage()
                    ], 500);
                }
            }

            // Crear el producto
            $producto = Producto::create([
                'idEmpresa' => Auth::user()->empresa->idEmpresa,
                'idCategoria' => $validated['idCategoria'],
                'idUnidad' => $validated['idUnidad'],
                'nombreProducto' => $validated['nombreProducto'],
                'descripcionProducto' => $validated['descripcionProducto'],
                'precioVentaProducto' => $validated['precioVentaProducto'],
                'tieneIGV' => $validated['tieneIGV'],
                'stockProducto' => $validated['stockProducto'],
                'urlImagenProducto' => $urlImagen,
                'idImagenProducto' => $idImagen
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto creado exitosamente',
                    'redirect' => route('productos.index')
                ]);
            }

            return redirect()->route('productos.index')
                ->with('success', 'Producto creado exitosamente');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $this->authorize('view', $producto);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);

        $empresa = Auth::user()->empresa;
        $categorias = $empresa->categorias()->orderBy('nombreCategoria')->get();
        $unidades = Unidad::orderBy('nombreUnidad')->get();

        return view('productos.edit', compact('producto', 'categorias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $validated = $request->validate([
            'nombreProducto' => 'required|string|max:150',
            'descripcionProducto' => 'nullable|string|max:500',
            'idCategoria' => 'required|exists:categoria,idCategoria',
            'idUnidad' => 'required|exists:unidad,idUnidad',
            'precioVentaProducto' => 'required|numeric|min:0|max:999999.99',
            'tieneIGV' => 'required|boolean',
            'stockProducto' => 'required|integer|min:0',
            'imagenProducto' => 'nullable|string',
            'cambiarImagen' => 'nullable|boolean'
        ]);

        try {
            $urlImagen = $producto->urlImagenProducto;
            $idImagen = $producto->idImagenProducto;

            // Si se solicita cambiar la imagen
            if ($request->cambiarImagen && $request->imagenProducto) {
                // Eliminar imagen anterior de Cloudinary si existe
                if ($producto->idImagenProducto) {
                    try {
                        $this->cloudinary->uploadApi()->destroy($producto->idImagenProducto);
                    } catch (\Exception $e) {
                        // Continuar aunque falle la eliminación
                    }
                }

                // Subir nueva imagen
                try {
                    $uploadResult = $this->cloudinary->uploadApi()->upload($request->imagenProducto, [
                        'folder' => 'productos',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'limit'
                        ]
                    ]);

                    $urlImagen = $uploadResult['secure_url'];
                    $idImagen = $uploadResult['public_id'];
                } catch (\Exception $uploadError) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al subir la nueva imagen: ' . $uploadError->getMessage()
                    ], 500);
                }
            }

            // Actualizar el producto
            $producto->update([
                'idCategoria' => $validated['idCategoria'],
                'idUnidad' => $validated['idUnidad'],
                'nombreProducto' => $validated['nombreProducto'],
                'descripcionProducto' => $validated['descripcionProducto'],
                'precioVentaProducto' => $validated['precioVentaProducto'],
                'tieneIGV' => $validated['tieneIGV'],
                'stockProducto' => $validated['stockProducto'],
                'urlImagenProducto' => $urlImagen,
                'idImagenProducto' => $idImagen
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto actualizado exitosamente',
                    'redirect' => route('productos.index')
                ]);
            }

            return redirect()->route('productos.index')
                ->with('success', 'Producto actualizado exitosamente');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        try {
            // Verificar si tiene ventas asociadas
            if ($producto->detalleVenta()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el producto porque tiene ventas asociadas'
                ], 400);
            }

            // Eliminar imagen de Cloudinary si existe
            if ($producto->idImagenProducto) {
                try {
                    $this->cloudinary->uploadApi()->destroy($producto->idImagenProducto);
                } catch (\Exception $e) {
                    // Continuar aunque falle la eliminación de la imagen
                }
            }

            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }
}

