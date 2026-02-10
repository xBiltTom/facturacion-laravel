<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //El usuario puede ver productos si tiene una empresa
        return $user->empresa()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Producto $producto): bool
    {
        // EL usuario solo puede ver productos de su empresa
        return $user->empresa->idEmpresa === $producto->idEmpresa;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // El usuario puede crear productos si tiene una empresa
        return $user->empresa()->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Producto $producto): bool
    {
        // El usuario solo puede actualizar productos de su empresa
        return $user->empresa->idEmpresa === $producto->idEmpresa;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Producto $producto): bool
    {
        // El usuario solo puede eliminar productos de su empresa
        return $user->empresa->idEmpresa === $producto->idEmpresa;
    }

    /**
     * Determine whether the user can restore the model.
     */
    /* public function restore(User $user, Producto $producto): bool
    {
        return false;
    } */

    /**
     * Determine whether the user can permanently delete the model.
     */
    /* public function forceDelete(User $user, Producto $producto): bool
    {
        return false;
    } */
}
