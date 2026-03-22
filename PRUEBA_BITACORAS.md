# 🧪 Guía Rápida de Prueba - Bitácoras

## Paso 1: Verificar Acceso a Bitácoras
1. Abre http://inventario.test
2. Ve al menú → **Bitácoras**
3. Deberías ver:
   - 4 tarjetas con stats (Total, Acciones Hoy, Usuarios, Última Actividad)
   - Buscador y filtros
   - Tabla vacía o con registros previos

## Paso 2: Crear un Producto (para generar registro)
1. Ve a **Productos** → **Agregar Producto**
2. Rellena:
   - Clave: `TEST-001`
   - Descripción: `Producto de Prueba`
   - Marca: `Test Brand`
   - Stock: `10`
3. Haz clic en **Guardar**

## Paso 3: Verifica Bitácora
1. Ve a **Bitácoras**
2. Deberías ver un nuevo registro:
   - ✓ Usuario: Tu nombre (actual)
   - ✓ Acción: "Crear" (badge verde)
   - ✓ Descripción: "Creó un nuevo producto: Producto de Prueba (Clave: TEST-001)"
   - ✓ Timestamp: Hace unos segundos

## Paso 4: Editar el Producto
1. Ve a **Productos**
2. Haz clic en el lápiz (edit) del producto TEST-001
3. Cambia:
   - Descripción a: `Producto Editado`
   - Marca a: `Nueva Marca`
4. Guarda

## Paso 5: Verifica Bitácora (Edición)
1. Ve a **Bitácoras**
2. Deberías ver un nuevo registro:
   - ✓ Acción: "Editar" (badge azul)
   - ✓ Descripción: "Editó el producto Producto de Prueba..."

## Paso 6: Probar Entrada en Inventario
1. Ve a **Inventario**
2. Selecciona el producto TEST-001
3. Cantidad: `5`
4. Tipo: `Entrada`
5. Agrega el movimiento

## Paso 7: Verifica Bitácora (Movimiento)
1. Ve a **Bitácoras**
2. Deberías ver un registro de entrada:
   - ✓ Descripción: "Registró una entrada de 5 unidades de Producto Editado"

## Paso 8: Prueba los Filtros
1. En **Bitácoras**, usa:
   - 🔍 Búsqueda: Busca "Producto"
   - 📋 Filtro Tipo: Selecciona "Crear"
   - 👤 Filtro Usuario: Tu usuario

2. Verifica que se filtren los resultados correctamente

## Paso 9: Prueba Limpiar Filtros
1. Haz clic en **🔄 Limpiar**
2. Deberían mostrarse todos los registros

---

## ✅ Criterios de Éxito

- ✅ Se pueden ver registros de crear producto
- ✅ Se pueden ver registros de editar producto  
- ✅ Se pueden ver registros de entrada/salida
- ✅ Los filtros funcionan correctamente
- ✅ Las stats se actualizan
- ✅ La UI es clara y moderna
- ✅ Los badges tienen colores diferentes por tipo

---

## 🐛 Si algo no funciona

**Error: "Class 'App\Helpers\BitacoraHelper' not found"**
- Solución: Asegúrate de que `app/Helpers/BitacoraHelper.php` exista
- Verifica que el namespace sea `namespace App\Helpers;`

**Error: "SQLSTATE[HY000]: General error"**
- Solución: Limpia la caché de Laravel
  ```bash
  cd c:\laragon\www\Inventario
  php artisan config:clear
  php artisan cache:clear
  ```

**Los registros no aparecen:**
- Verifica que la tabla `bitacoras` tenga datos
- En MySQL: `SELECT * FROM bitacoras;`
- Si está vacía, crea un producto nuevo

---

## 📊 Resultado Esperado

### Vista de Bitácoras debería verse así:

```
╔════════════════════════════════════════════════════════════╗
║                    Bitácoras                              ║
╠════════════════════════════════════════════════════════════╣
║                                                            ║
║  📊 7 Total    ⏱️ 3 Hoy    👥 1 Usuario    ⚡ Hace 2 min  ║
║                                                            ║
║  [Buscador...]  [Tipo ▼] [Usuario ▼]  [Filtrar] [Limpiar]║
║                                                            ║
║  ✓ Juan        [Crear]   Creó producto...    3 min       ║
║  ✏ María       [Editar]  Editó producto...   1 min       ║
║  ↔ Carlos      [Crear]   Entrada 5 unid...   Ahora       ║
║                                                            ║
╚════════════════════════════════════════════════════════════╝
```

---

**¡Listo para probar! 🚀**
