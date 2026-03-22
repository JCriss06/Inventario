# Inventario TSM Total Security

Sistema web para la gestión y control de inventario, desarrollado como solución a medida para la empresa TSM Sistemas Integrales en Ciudad Madero, Tamaulipas. El proyecto permite administrar productos, registrar movimientos de stock, componer kits, generar reportes y auditar todas las acciones realizadas en la plataforma.

## Tecnologías Utilizadas

El sistema está construido sobre un stack de tecnologías moderno y robusto, garantizando rendimiento, seguridad y escalabilidad.

- **Backend:**
  - Laravel 12
  - PHP 8.2
  - Eloquent ORM

- **Frontend:**
  - Tailwind CSS
  - Alpine.js
  - Blade
  - Vite

- **Base de Datos:**
  - MySQL

- **Componentes Clave:**
  - **Autenticación y Roles:** Spatie Laravel Permission
  - **Exportación a PDF:** DomPDF
  - **Entorno de Desarrollo:** Laragon

## Funcionalidades Principales

El sistema se organiza en módulos especializados para cubrir todas las necesidades de la gestión de inventario.

- **Dashboard Ejecutivo:**
  - Ofrece una vista rápida del estado del inventario a través de 4 KPIs dinámicos: total de productos, productos con stock bajo, valor total del stock y movimientos del día.
  - Incluye una sección de "Top 5 Productos Críticos" que alerta sobre artículos con 10 o menos unidades disponibles.

- **Gestión de Productos:**
  - Catálogo completo de productos con un buscador dinámico en tiempo real (AJAX) para una localización rápida.
  - Soporte para carga masiva de productos desde archivos y localización de la interfaz al español.

- **Sistema de Inventario:**
  - Permite registrar entradas y salidas de stock por lotes, facilitando la actualización masiva de existencias.

- **Módulo de Kits:**
  - Funcionalidad para crear y gestionar "kits" de productos, manejando una relación muchos a muchos que permite agrupar artículos para su venta o distribución conjunta.

- **Reportes Analíticos:**
  - Generación de reportes de inventario con filtros multi-criterio (por fecha, tipo de movimiento, producto, etc.).
  - Capacidad de exportar los reportes a formato PDF, optimizado para manejar de forma eficiente más de 500 registros por documento.

- **Bitácoras de Auditoría:**
  - Registro automático y detallado de todas las acciones críticas realizadas en el sistema (creación, actualización, eliminación).
  - Interfaz con filtros dinámicos para consultar la actividad por usuario, fecha o tipo de acción, y estadísticas de uso.

- **Control de Acceso (ACL):**
  - Sistema de roles y permisos basado en Spatie, con 2 roles predefinidos (Administrador y Empleado) y 11 permisos granulares que restringen el acceso a las funcionalidades según el perfil del usuario.

## Instalación y Configuración

Para ejecutar el proyecto en un entorno de desarrollo local, sigue estos pasos:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/inventario-tsm.git
   cd inventario-tsm
   ```

2. **Instalar dependencias de Backend:**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Frontend:**
   ```bash
   npm install
   ```

4. **Configurar el entorno:**
   - Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`.
   - Configura las variables de entorno, especialmente la conexión a la base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

5. **Ejecutar las migraciones y seeders:**
   - Esto creará la estructura de la base de datos y cargará los datos iniciales (roles, permisos, etc.).
   ```bash
   php artisan migrate --seed
   ```

6. **Compilar los assets de Frontend:**
   ```bash
   npm run dev
   ```

7. **Iniciar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```

El proyecto estará disponible en `http://127.0.0.1:8000`.

## Estructura del Proyecto

La organización de los directorios sigue las convenciones de Laravel para mantener un código limpio y ordenado.

```
Inventario/
├── app/
│   ├── Http/
│   │   └── Controllers/  // Lógica de negocio y peticiones
│   ├── Models/           // Modelos de Eloquent
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/       // Estructura de la base de datos
│   └── seeders/          // Datos iniciales
├── resources/
│   ├── css/
│   ├── js/
│   └── views/            // Vistas de Blade
├── routes/
│   └── web.php           // Rutas de la aplicación web
└── ...
```

## Créditos

- **Desarrollado por:** Jesus Cristobal (JCriss06) y alfonso1410.
- **Proyecto para:** TSM Sistemas Integrales.
- **Periodo:** Diciembre 2025 - Enero 2026.

