<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;

class CategoriaPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier categoría
     */
    public function viewAny(User $user): bool
    {
        // El usuario puede ver categorías si tiene una empresa
        return $user->empresa()->exists();
    }

    /**
     * Determinar si el usuario puede ver una categoría específica
     */
    public function view(User $user, Categoria $categoria): bool
    {
        // El usuario solo puede ver categorías de su empresa
        return $user->empresa->idEmpresa === $categoria->idEmpresa;
    }

    /**
     * Determinar si el usuario puede crear categorías
     */
    public function create(User $user): bool
    {
        // El usuario puede crear categorías si tiene una empresa
        return $user->empresa()->exists();
    }

    /**
     * Determinar si el usuario puede actualizar una categoría
     */
    public function update(User $user, Categoria $categoria): bool
    {
        // El usuario solo puede actualizar categorías de su empresa
        return $user->empresa->idEmpresa === $categoria->idEmpresa;
    }

    /**
     * Determinar si el usuario puede eliminar una categoría
     */
    public function delete(User $user, Categoria $categoria): bool
    {
        // El usuario solo puede eliminar categorías de su empresa
        return $user->empresa->idEmpresa === $categoria->idEmpresa;
    }
}
