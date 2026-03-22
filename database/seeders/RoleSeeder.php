<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definir Permisos
        $permissions = [
            // Gestión de Usuarios
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
            
            // Productos
            'ver productos', 'crear productos', 'editar productos', 'eliminar productos',
            
            // Inventario (Unificado)
            'gestionar inventario',
            
            // Módulos
            'ver reportes',
            'ver bitacoras',
        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Crear Roles
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleEmpleado = Role::firstOrCreate(['name' => 'Empleado']);

        // El admin siempre tendrá todos los permisos
        $roleAdmin->givePermissionTo(Permission::all());

        // 4. Crear Usuario Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Buscamos por email para no duplicar
            [
                'name' => 'prueba',
                'puesto' => 'Administrador',
                'password' => Hash::make('password'), // Contraseña: password
                'email_verified_at' => now(),
            ]
        );

        // Asignar el Rol de Admin al usuario creado
        $adminUser->assignRole($roleAdmin);
    }
}