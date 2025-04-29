<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios paginada.
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Generar código de usuario único de manera segura (6 caracteres)
        do {
            $codigo = strtoupper(Str::random(6));
        } while (User::where('codigo', $codigo)->exists());

        // Generar contraseña temporal
        $tempPassword = Str::random(10);

        return view('admin.users.create', compact('codigo', 'tempPassword'));
    }

    /**
     * Almacena un nuevo usuario con código y contraseña temporal automáticos.
     */
    public function store(Request $request)
    {
        // Validar campos, incluyendo código y contraseña temporal
        $data = $request->validate([
            'codigo'            => 'required|string|size:6|unique:users,codigo',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'identificacion'    => 'required|string|max:100',
            'establecimiento'   => 'required|string|max:255',
            'telefono'          => 'required|string|max:20',
            'direccion'         => 'required|string|max:255',
            'role'              => ['required', Rule::in(['user','admin'])],
            'password_temporal' => 'required|string|min:8',
        ]);

        // Hashear la contraseña temporal y asignar la contraseña principal
        $data['password'] = Hash::make($data['password_temporal']);

        // Crear usuario en BD
        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Usuario creado correctamente. Contraseña temporal: {$data['password_temporal']}");
    }

    /**
     * Muestra detalles de un usuario.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulario para editar usuario existente.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza datos del usuario.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'identificacion' => 'required|string|max:100',
            'establecimiento'=> 'required|string|max:255',
            'telefono'       => 'required|string|max:20',
            'direccion'      => 'required|string|max:255',
            'role'           => ['required', Rule::in(['user','admin'])],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
