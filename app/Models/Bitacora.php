<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitacora extends Model
{
    protected $fillable = ['user_id', 'accion', 'registro_id', 'descripcion'];

    /**
     * Relación con el usuario que realizó la acción
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el color del badge según la acción
     */
    public function getActionColorAttribute(): string
    {
        return match($this->accion) {
            'crear' => 'green',
            'editar' => 'blue',
            'eliminar' => 'red',
            'sesion' => 'purple',
            default => 'gray',
        };
    }

    /**
     * Obtener el ícono según la acción
     */
    public function getActionIconAttribute(): string
    {
        return match($this->accion) {
            'crear' => 'plus-circle',
            'editar' => 'pencil',
            'eliminar' => 'trash',
            'sesion' => 'user',
            default => 'document',
        };
    }
}
