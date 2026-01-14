<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Product extends Model
{

    protected $fillable = ['clave', 'descripcion', 'marca', 'stock'];
    
    public function reportes(): HasMany{
        return $this->hasMany(Reporte::class);
    }

    /**
     * Relación con kits
     */
    public function kits(): BelongsToMany
    {
        return $this->belongsToMany(Kit::class, 'kit_products')
            ->withPivot('cantidad')
            ->withTimestamps();
    }


    protected function clave(): Attribute{

        return Attribute::make(
            set: fn ($value) => strtoupper(trim($value)),
        );
    }
}
