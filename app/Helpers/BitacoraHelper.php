<?php

namespace App\Helpers;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraHelper
{
    /**
     * Registrar una acción en la bitácora
     * 
     * @param string $accion - Tipo de acción (crear, editar, eliminar, sesion)
     * @param string $descripcion - Descripción detallada de la acción
     * @param int|null $registro_id - ID del registro afectado (opcional)
     */
    public static function registrar($accion, $descripcion, $registro_id = null)
    {
        try {
            Bitacora::create([
                'user_id' => Auth::id(),
                'accion' => $accion,
                'descripcion' => $descripcion,
                'registro_id' => $registro_id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Registrar creación de producto
     */
    public static function registrarCrearProducto($producto)
    {
        self::registrar(
            'crear',
            'Creó un nuevo producto: ' . $producto->descripcion . ' (Clave: ' . $producto->clave . ')',
            $producto->id
        );
    }

    /**
     * Registrar edición de producto
     */
    public static function registrarEditarProducto($producto, $cambios)
    {
        $detalles = [];
        foreach ($cambios as $campo => $valor) {
            $detalles[] = $campo . ': ' . json_encode($valor);
        }
        
        self::registrar(
            'editar',
            'Editó el producto ' . $producto->descripcion . ' (' . implode(', ', $detalles) . ')',
            $producto->id
        );
    }

    /**
     * Registrar eliminación de producto
     */
    public static function registrarEliminarProducto($producto)
    {
        self::registrar(
            'eliminar',
            'Eliminó el producto: ' . $producto->descripcion . ' (Clave: ' . $producto->clave . ')',
            $producto->id
        );
    }

    /**
     * Registrar entrada/salida de inventario
     */
    public static function registrarMovimiento($tipo, $producto, $cantidad, $motivo = null)
    {
        // Usar entrada o salida como acción
        $accion = $tipo === 'entrada' ? 'entrada' : 'salida';
        $descripcion = 'Registró una ' . $tipo . ' de ' . $cantidad . ' unidad(es) de ' . $producto->descripcion;
        
        if ($motivo) {
            $descripcion .= ' - Motivo: ' . $motivo;
        }
        
        self::registrar($accion, $descripcion, $producto->id);
    }

    /**
     * Registrar login de usuario
     */
    public static function registrarLogin($usuario)
    {
        self::registrar(
            'sesion',
            'Inició sesión en el sistema',
            null
        );
    }

    /**
     * Registrar logout de usuario
     */
    public static function registrarLogout($usuario)
    {
        self::registrar(
            'sesion',
            'Cerró sesión en el sistema',
            null
        );
    }
}
