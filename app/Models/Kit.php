<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kit extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'codigo_kit'];

    /**
     * Relación muchos a muchos con productos
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'kit_products')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    /**
     * Obtener la cantidad total de items en el kit
     */
    public function getCantidadTotalAttribute(): int
    {
        return $this->productos->sum('pivot.cantidad');
    }
}
