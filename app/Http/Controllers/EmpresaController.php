<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class EmpresaController extends Controller
{

    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(config('cloudinary.cloud_url'));
    }

    /**
     * Muestra el formulario de registro de empresa
     */
    public function create()
    {
        // Verificar si el usuario ya tiene una empresa
        if (Auth::user()->empresa()->exists()) {
            return redirect()->back()->with('has_company','Ya tienes una empresa registrada');
        }

        return view('empresa.create');
    }

    /**
     * Almacena una nueva empresa
     */
    public function store(Request $request)
    {
        // Verificar si el usuario ya tiene una empresa
        if (Auth::user()->empresa()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes una empresa registrada'
            ], 400);
        }

        // Validar los datos
        $validated = $request->validate([
            'razonSocialEmpresa' => 'required|string|max:255',
            'rucEmpresa' => 'required|string|max:20|unique:empresa,rucEmpresa',
            'telefonoEmpresa' => 'required|string|max:20',
            'direccionEmpresa' => 'required|string|max:500',
            'logoEmpresa' => 'required|string' // Base64 o URL de Cloudinary
        ]);

        try {
            $urlLogo = null;
            $idLogo = null;

            // Subir logo a Cloudinary desde base64
            if ($request->logoEmpresa) {
                try {
                    $uploadResult = $this->cloudinary->uploadApi()->upload($request->logoEmpresa, [
                        'folder' => 'empresas/logos',
                        'transformation' => [
                            'width' => 500,
                            'height' => 500,
                            'crop' => 'limit'
                        ]
                    ]);

                    $urlLogo = $uploadResult['secure_url'];
                    $idLogo = $uploadResult['public_id'];
                } catch (\Exception $uploadError) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al subir el logo a Cloudinary: ' . $uploadError->getMessage()
                    ], 500);
                }
            }

            // Crear la empresa
            $empresa = Empresa::create([
                'razonSocialEmpresa' => $validated['razonSocialEmpresa'],
                'rucEmpresa' => $validated['rucEmpresa'],
                'telefonoEmpresa' => $validated['telefonoEmpresa'],
                'direccionEmpresa' => $validated['direccionEmpresa'],
                'urlLogoEmpresa' => $urlLogo,
                'idLogoEmpresa' => $idLogo,
                'idUsuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa registrada exitosamente',
                'redirect' => route('dashboard.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la empresa: ' . $e->getMessage()
            ], 500);
        }
    }
}
