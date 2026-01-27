<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class UserController extends Controller
{

public static function middleware(): array
    {
        return [
            // Index: Lo ve quien tenga permiso 'ver usuarios' (Admin o Empleado con permiso)
            new Middleware('can:ver usuarios', only: ['index']),

            // El resto: Requiere permisos específicos
            // Nota: El Admin pasa automáticamente si tiene todos los permisos asignados
            new Middleware('can:crear usuarios', only: ['create', 'store']),
            new Middleware('can:editar usuarios', only: ['edit', 'update']),
            new Middleware('can:eliminar usuarios', only: ['destroy']),
        ];
    }
    public function index()
    {
        // Cargamos los usuarios y sus roles para evitar consultas N+1 en la vista
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Enviamos roles y todos los permisos disponibles a la vista
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'puesto' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'], // Validamos que el rol exista
            'permissions' => ['array'], // Opcional, pero si viene debe ser un arreglo
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'puesto' => $request->puesto,
            'password' => Hash::make($request->password),
        ]);

        // 1. Asignar el Rol (Admin o Empleado)
        $user->assignRole($request->role);

        // 2. Asignar permisos específicos (si se seleccionaron)
        // Esto permite que un Empleado tenga permisos "a la carta"
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado y configurado exitosamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'puesto' => ['required', 'string', 'max:100'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'permissions' => ['array'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'puesto' => $request->puesto,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // 1. Sincronizar Rol (quita el anterior y pone el nuevo)
        $user->syncRoles($request->role);

        // 2. Sincronizar Permisos
        // Usamos 'permissions' del request, o un array vacío [] si no se marcó nada.
        // Esto asegura que si desmarcas todo, se le quiten los permisos al usuario.
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta mientras estás logueado.');
        }

        // Al eliminar el usuario, Spatie automáticamente limpia las relaciones en la DB
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}